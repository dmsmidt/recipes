<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IMenuItemRepository;
use App\Models\MenuItem;

class MenuItemRepository extends BaseRepository implements IMenuItemRepository{

    public function selectTree($parent_id = null){
        return MenuItem::where('menu_id',$parent_id)->get()->toHierarchy()->toArray();
    }

    public function SelectById($parent_id, $id){
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

    public function delete($parent_id, $id){
        $model = MenuItem::find($id);
        $model->delete();
        $this->deleteTranslations('menu_items',$id);
    }
}