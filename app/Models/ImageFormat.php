<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageFormat extends Model {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'image_formats';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["image_id","name","x","y","width","height","scaling"];

    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected $quarded = ["id"];

    /**
     * Retrieve inverse has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_format_id');
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