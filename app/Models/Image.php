<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'images';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["image_template","filename"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id"];

    /**
     * Querying relations
     * @var array
     */
    protected $with = ["image_formats","language"];

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image_formats()
    {
        return $this->hasMany('App\Models\ImageFormat', 'image_id');
    }

    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function language()
    {
        return $this->hasMany('App\Models\ImagesLang', 'image_id');
    }

    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public $timestamps = true;

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
    public $protectable = false;

}