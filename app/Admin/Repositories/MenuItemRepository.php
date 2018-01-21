<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuItemRepository;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository implements IMenuItemRepository{

    public function selectTree(){
        return MenuItem::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return MenuItem::find($id);
    }

    public function add($input){
        $model = new MenuItem;
        $model->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $model->id);
    }

    public function update($input, $id){
        $model = MenuItem::find($id);
        $model->fill($input)->save();
        $this->saveTranslations('menu_items',$input, $model->id);
    }

    public function delete($id){
        $model = MenuItem::find($id);
        $model->delete();
        $this->deleteTranslations('menu_items',$id);
    }
}