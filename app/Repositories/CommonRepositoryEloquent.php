<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CommonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
abstract class CommonRepositoryEloquent extends BaseRepository implements CommonRepository
{
    /**
     * @param array $columns
     * @param $value
     * @return mixed|null
     */
    public function orLikes($value, $columns = [])
    {
        if (count($columns) > 0) {
            $model = $this->model->where(function ($q) use ($columns, $value) {
                $q->orWhere($columns[0], 'like', '%' . $value . '%');
                for ($i = 1, $iMax = count($columns); $i < $iMax; ++$i) {
                    $q->orWhere($columns[$i], 'like', '%' . $value . '%');
                }
            });

            return $this->parserResult($model);
        }

        return null;
    }

    /**
     * @param $column
     * @param string $operator
     * @param $value
     *
     * @return mixed
     */
    public function where($column, $value, $operator = '=')
    {
        /** @var Model $model */
        $model = $this->model->where($column, $operator, $value);

        return $this->parserResult($model);
    }
}
