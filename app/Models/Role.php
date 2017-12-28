<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'roles';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["name"];

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id');
    }

    /*
     * Retrieve many_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menuItems()
    {
        return $this->belongsToMany('App\Models\MenuItem', 'menu_items_roles', 'role_id', 'menu_item_id');
    }

    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public $timestamps = false;

    /**
     * Manage parent_id, lft, rgt and level to manage nested sets for sortable lists
     * @var bool
     */
    public $sortable = false;

    /**
     * Manage parent_id, lft, rgt and level to manage nested sets for nested lists
     * @var bool
     */
    public $nestable = false;

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