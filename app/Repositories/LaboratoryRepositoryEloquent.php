<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LaboratoryRepository;
use App\Entities\Laboratory;
use App\Validators\LaboratoryValidator;

/**
 * Class LaboratoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LaboratoryRepositoryEloquent extends BaseRepository implements LaboratoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Laboratory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
