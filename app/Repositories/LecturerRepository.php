<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LecturerRepository.
 *
 * @package namespace App\Repositories;
 */
interface LecturerRepository extends RepositoryInterface
{
    /**
     * @param $param
     * @return mixed
     */
    public function createLecturer($param);
}
