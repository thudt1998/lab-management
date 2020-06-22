<?php

namespace App\Repositories;

use App\Entities\Student;
use App\Events\SendPassword;
use App\Validators\StudentValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StudentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StudentRepositoryEloquent extends BaseRepository implements StudentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Student::class;
    }

    /**
     * @param $param
     * @return mixed|void
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createStudent($param)
    {
        $password = Str::random(8);
        $lecturer = [
            'lecturer_id' => $param['lecturer_id'],
            'name' => $param['name'],
            'email' => $param['email'],
            'password' => Hash::make($password),
            'class' => $param['class']
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
