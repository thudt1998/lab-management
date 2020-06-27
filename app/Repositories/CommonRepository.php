<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CommonRepository.
 *
 * @package namespace App\Repositories;
 */
interface CommonRepository extends RepositoryInterface
{
    /**
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function orLikes($value, $columns = []);

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return mixed
     */
    public function where($column, $value, $operator = '=');

    /**
     * @param $column
     * @return mixed
     */
}
