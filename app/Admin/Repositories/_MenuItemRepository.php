<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuItemRepository;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository implements IMenuItemRepository{

    public function selectTree($parent_id = null){
        $menu_items = MenuItem::where('menu_id',$parent_id)->get()->toHierarchy()->toArray();
        return $menu_items;
    }

    public function SelectById($id){
        return MenuItem::find($id)->toArray();
    }

    public function add($input, $parent_id){
        $menu_item = new MenuItem;
        $input['menu_id'] = $parent_id;
        $menu_item->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $menu_item->id);
        if($parent_id == 1){
            $result = \App\Models\Role::all();
            $roles = [];
            foreach($result as $role){
                $roles[] = $role->id;
            }
            $menu_item->roles()->attach($roles);
        }
    }

    public function update($input, $id){
        $menu_item = MenuItem::find($id);
        $menu_item->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $id);
    }

    public function delete($parent_id, $id){
        $menu_item = MenuItem::find($id);
        $menu_item->delete();
        if($parent_id == 1){
            $menu_item->roles()->detach();
        }
        $this->deleteTranslations('menu_items',$id);
        MenuItem::rebuild(true);
    }



} 