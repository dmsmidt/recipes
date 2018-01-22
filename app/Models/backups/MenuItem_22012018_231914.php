<?php namespace App\Models;

use Baum\Node;

class MenuItem extends Node {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * parent id in nestedset
     * @var string
     */
     protected $parentColumn = 'parent_id';

     /**
     * left node index
     * @var string
     */
    protected $leftColumn = 'lft';

    /**
     * right node index
     * @var string
     */
    protected $rightColumn = 'rgt';

    /**
     * depth level of node
     * @var string
     */
    protected $depthColumn = 'level';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["menu_id","name","icon","url"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id","parent_id","lft","rgt","level"];

    /**
     * Columns which restrict what we consider our Nested Set list
     * @var array
     */
    protected $scoped = ["menu_id"];

    /**
     * Retrieve has_one relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menuId()
    {
        return $this->hasOne('App\Models\Menu','id');
    }

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function text()
    {
        return $this->hasMany('App\Models\MenuItemsLang', 'menu_item_id');
    }

    /*
     * Retrieve many_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\MenuItem', 'menu_items_roles', 'menu_item_id', 'role_id');
    }

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function language()
    {
        return $this->hasMany('App\Models\MenuItemsLang', 'menu_item_id');
    }


    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public $timestamps = false;

    /**
     * Manage index to sort the model items
     * @var bool
     */
    public $sortable = false;

    /**
     * Manage parent_id, lft, rgt and level to manage nested sets
     * @var bool
     */
    public $nestable = true;

    /**
     * Manage active field to turn on/off the model item
     * @var bool
     */
    public $activatable = true;

    /**
     * Manage protect field to lock modifications by user roles except for developer
     * @var bool
     */
    public $protectable = true;

}