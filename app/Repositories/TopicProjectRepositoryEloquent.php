<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\topic_projectRepository;
use App\Entities\TopicProject;
use App\Validators\TopicProjectValidator;

/**
 * Class TopicProjectRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TopicProjectRepositoryEloquent extends BaseRepository implements TopicProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TopicProject::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
