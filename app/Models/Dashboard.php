<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'dashboard';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["name"];

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
    public $activatable = true;

    /**
     * Manage protect field to lock modifications by user roles except for developer
     * @var bool
     */
    public $protectable = true;

}