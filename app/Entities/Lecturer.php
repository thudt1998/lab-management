<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Lecturer.
 *
 * @package namespace App\Entities;
 */
class Lecturer extends Authenticatable
{

    use Notifiable;

    protected $guarded = "lecturer";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'subject_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany(Project::class);
    }

}
