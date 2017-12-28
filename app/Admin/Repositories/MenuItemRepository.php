<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuItemRepository;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository implements IMenuItemRepository{

    public function selectTree($parent_id){
        $menu_items = MenuItem::where('menu_id',$parent_id)->get()->toHierarchy()->toArray();
        return $menu_items;
    }

    public function SelectById($id){
        return MenuItem::find($id);
    }

    public function add($input, $parent_id){
        $model = new MenuItem;
        $input['menu_id'] = $parent_id;
        $model->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $model->id);
        /*if($parent_id == 1){
            $result = \App\Models\Role::all();
            $roles = [];
            foreach($result as $role){
                $roles[] = $role->id;
            }
            $model->roles()->attach($roles);
        }*/
    }

    public function update($input, $id){
        $model = MenuItem::find($id);
        $model->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $model->id);
    }

    public function delete($parent_id, $id){
        $model = MenuItem::find($id);
        $model->delete();
        /*if($parent_id == 1){
            $model->roles()->detach();
        }*/
        $this->deleteTranslations('menu_items',$id);
        MenuItem::rebuild(true);
    }
}