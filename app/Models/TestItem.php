<?php namespace App\Models;

use Baum\Node;

class TestItem extends Node {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'test_items';

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
     * Columns which restrict what we consider our Nested Set list
     * @var array
     */
    protected $scoped = ["test_id"];

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["test_id","name","icon","url"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id","parent_id","lft","rgt","level"];

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function test_items_lang()
    {
        return $this->hasMany('App\Models\TestItemsLang', 'test_item_id');
    }

    /**
     * Retrieve inverse has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function test()
    {
        return $this->belongsTo('App\Models\Test', 'test_item_id');
    }

    /**
     * Retrieve many_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
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