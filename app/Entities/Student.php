<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Student.
 *
 * @package namespace App\Entities;
 */
class Student extends Authenticatable
{
    use Notifiable;

    protected $guarded = "student";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'lecturer_id',
        'name',
        'email',
        'password',
        'class'
    ];

    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_students', 'student_id', 'project_id');
    }

}
