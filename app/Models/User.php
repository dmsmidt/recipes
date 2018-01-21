<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'users';

    /**
     * Fields that are hidden from view
     * @var array
     */
    protected $hidden = ["password","remember_token"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'language', 'role_id'
    ];

    /**
     * Retrieve has_one relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public $timestamps = true;

    /**
     * Manage index to sort the model items
     * @var bool
     */
    public $sortable = false;

    /**
     * Manage active field to turn on/off the model item
     * @var bool
     */
    public $activatable = false;

    /**
     * Manage protect field to lock modifications by user roles except for developer
     * @var bool
     */
    public $protectable = false;


}
