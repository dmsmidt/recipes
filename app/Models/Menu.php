<?php namespace App\Models;

use Baum\Node;

class Menu extends Node {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'menus';

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
    protected $fillable = ["name","levels"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id"];

    /**
     * Querying relations
     * @var array
     */
    protected $with = ["menu_items"];

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menu_items()
    {
        return $this->hasMany('App\Models\MenuItem', 'menu_id');
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
    public $sortable = true;

    /**
     * Manage parent_id, lft, rgt and level to manage nested sets for nested lists
     * @var bool
     */
    public $nestable = false;

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