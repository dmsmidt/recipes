<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IPageRepository;
use App\Models\Page;

class PageRepository extends BaseRepository implements IPageRepository{

    public function selectAll(){
        return Page::all()->toArray();
    }

    public function SelectById($id){
        return Page::find($id);
    }

    public function add($input){
        $model = new Page;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Page::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Page::find($id);
        $model->delete();
        
    }

}