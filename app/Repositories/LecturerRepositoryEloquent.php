<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LecturerRepository;
use App\Entities\Lecturer;
use App\Validators\LecturerValidator;

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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
