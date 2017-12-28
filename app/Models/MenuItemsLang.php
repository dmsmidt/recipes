<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemsLang extends Model {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table = 'menu_items_lang';

    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected $fillable = ["menu_item_id","language_id","text"];

    /**
     * Retrieve has_one relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menuItemId()
    {
        return $this->hasOne('App\Models\MenuItems','id');
    }

    /**
     * Retrieve has_one relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function languageId()
    {
        return $this->hasOne('App\Models\Languages','id');
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