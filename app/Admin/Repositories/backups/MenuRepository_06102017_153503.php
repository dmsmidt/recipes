<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuRepository;
use App\Models\Menu;

class MenuRepository extends BaseRepository implements IMenuRepository{

    public function selectTree(){
        return Menu::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return Menu::find($id);
    }

    public function add($input){
        $model = new Menu;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Menu::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Menu::find($id);
        $model->menu_items->delete();
        $model->delete();
    }
}