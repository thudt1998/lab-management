<?php

namespace App\Rules;

use App\Entities\Project;
use Illuminate\Contracts\Validation\Rule;

class PeriodExist implements Rule
{
    public $id;

    public $compartmentId;

    public $startDate;

    /**
     * Create a new rule instance.
     *
     * @param $id
     * @param $compartmentId
     * @param $startDate
     */
    public function __construct($id, $compartmentId, $startDate)
    {
        $this->id = $id;
        $this->compartmentId = $compartmentId;
        $this->startDate = $startDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = date('Y-m-d', strtotime($value));
        $start = date('Y-m-d', strtotime($this->startDate));
        $project = Project::where('compartment_id', $this->compartmentId)
            ->whereExists(function ($query) use ($value, $start) {
                return $query->where([['date_start', '<', $value], ['date_finish', '>=', $value]])
                    ->orWhere([['date_finish', '>', $start], ['date_finish', '<', $value]]);
            });
        if ($this->id !== null) {
            $project = $project->whereNotIn('id', [$this->id]);
        }
        $project = $project->get()->toArray();
        if (empty($project)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Thời gian đã có project.';
    }
}
