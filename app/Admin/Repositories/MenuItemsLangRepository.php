<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuItemsLangRepository;
use App\Models\MenuItemsLang;

class MenuItemsLangRepository extends BaseRepository implements IMenuItemsLangRepository{

    public function selectAll(){
        return MenuItemsLang::all()->toArray();
    }

    public function SelectById($id){
        return MenuItemsLang::find($id);
    }

    public function add($input){
        $model = new MenuItemsLang;
        $model->fill($input)->save();
        
        
        return $model;
    }

    public function update($input, $id){
        $model = MenuItemsLang::find($id);
        $model->fill($input)->save();
        
        
        return $model;
    }

    public function delete($id){
        $model = MenuItemsLang::find($id);
        $model->delete();
        
    }

}