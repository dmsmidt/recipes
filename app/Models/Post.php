<?php namespace App\Models;

use Baum\Node;

class Post extends Node {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'posts';

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
    protected $fillable = ["title","text"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id"];

    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public $timestamps = true;

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