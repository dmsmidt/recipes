<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IRoleRepository;
use App\Models\Role;

class RoleRepository extends BaseRepository implements IRoleRepository{

    public function selectAll(){
        return Role::all()->toArray();
    }

    public function SelectById($id){
        $role = Role::find($id);
        $menu_items = $role->menuItems;
        $data = $role->toArray();
        $ids = [];
        foreach($menu_items as $menu_item){
            $ids[] = $menu_item->id;
        }
        $data['menu_items'] = $ids;
        return $data;
    }

    public function add($input){
        $model = new Role;
        $model->fill($input)->save();

        $group_prefix = 'menu_items';
        $menu_items = [];
        foreach($input as $field => $value){
            if(strpos($field,$group_prefix) !== false){
                $menu_items[] = $value;
            }
        }
        $model->menuItems()->attach($menu_items);
    }

    public function update($input, $id){
        $model = Role::find($id);
        $model->fill($input)->save();
        $model->menuItems()->detach();
        $group_prefix = 'menu_items';
        $menu_items = [];
        foreach($input as $field => $value){
            if(strpos($field,$group_prefix) !== false){
                $menu_items[] = $value;
            }
        }
        $model->menuItems()->attach($menu_items);
    }

    public function delete($id){
        $model = Role::find($id);
        /*$users = $role->users;
        if(count($users)){
            //action to inform that users are bind to this role
        }*/
        $model->menuItems()->detach();
        $model->delete();
    }
}