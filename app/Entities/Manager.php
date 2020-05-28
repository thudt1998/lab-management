<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Manager.
 *
 * @package namespace App\Entities;
 */
class Manager extends Authenticatable
{
    use Notifiable;

    protected $guarded = 'manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email'
    ];



}
