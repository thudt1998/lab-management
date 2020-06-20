<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProjectStudentRepository;
use App\Entities\ProjectStudent;
use App\Validators\ProjectStudentValidator;

/**
 * Class ProjectStudentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProjectStudentRepositoryEloquent extends BaseRepository implements ProjectStudentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectStudent::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
