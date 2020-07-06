<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompartmentRepository;
use App\Entities\Compartment;
use App\Validators\CompartmentValidator;

/**
 * Class CompartmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompartmentRepositoryEloquent extends BaseRepository implements CompartmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Compartment::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
