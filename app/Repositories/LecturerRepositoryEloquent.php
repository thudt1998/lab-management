<?php

namespace App\Repositories;

use App\Entities\Lecturer;
use App\Events\SendPassword;
use App\Validators\LecturerValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class LecturerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LecturerRepositoryEloquent extends BaseRepository implements LecturerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lecturer::class;
    }

    /**
     * @param $param
     * @return mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createLecturer($param)
    {
        $password = Str::random(8);
        $lecturer = [
            'name' => $param['name'],
            'password' => Hash::make($password),
            'email' => $param['email'],
            'subject_id' => $param['subject']
        ];
        $this->create($lecturer);
        event(new SendPassword($param['email'], $password));
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
