<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StudentRepository.
 *
 * @package namespace App\Repositories;
 */
interface StudentRepository extends RepositoryInterface
{
    /**
     * @param $param
     * @return mixed
     */
    public function createStudent($param);
}
