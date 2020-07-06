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
class LecturerRepositoryEloquent extends CommonRepositoryEloquent implements LecturerRepository
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
     * @param $param
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function getListLecturers($param){
        $sort = $param['sort'] ?? 'ASC';
        $entry = 10;
        $lecturers = $this->with(['subject','projects'])->withCount('projects')->orderBy('name', $sort);

        if (isset($param['keyword']) && $param['keyword'] !== null) {
            $lecturers->searchByKeyword($param['keyword'], $lecturers);
        }

        return $lecturers->paginate($entry);
    }

    /**
     * @param $keyword
     * @param $lecturers
     * @return mixed
     */
    private function searchByKeyword($keyword, &$lecturers)
    {
        $columns = ['name','email'];
        return $lecturers->orLikes($keyword, $columns);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
