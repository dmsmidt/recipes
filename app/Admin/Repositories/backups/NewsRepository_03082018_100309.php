<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\INewsRepository;
use App\Models\News;

class NewsRepository extends BaseRepository implements INewsRepository{

    public function selectAll(){
        return News::all()->toArray();
    }

    public function SelectById($id){
        return News::find($id);
    }

    public function add($input){
        $model = new News;
        $model->fill($input)->save();
        
        
        return $model;
    }

    public function update($input, $id){
        $model = News::find($id);
        $model->fill($input)->save();
        
        
        return $model;
    }

    public function delete($id){
        $model = News::find($id);
        $model->delete();
        
    }

}