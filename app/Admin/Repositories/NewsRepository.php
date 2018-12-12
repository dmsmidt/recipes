<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\INewsRepository;
use App\Models\News;

class NewsRepository extends BaseRepository implements INewsRepository{

    public function selectTree(){
        return News::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return News::find($id);
    }

    public function add($input){
        $model = new News;
        $model->fill($input)->save();
        $foreign_ids = [];
        if(isset($input['main_image'])){
            foreach($this->foreignToArray($input['main_image']) as $foreign){
                $foreign_ids[] = $foreign['id'];
            }
        }
        if(isset($input['sub_image'])){
            foreach($this->foreignToArray($input['sub_image']) as $foreign){
                $foreign_ids[] = $foreign['id'];
            }
        }
       $model->images()->sync($foreign_ids);

        
        return $model;
    }

    public function update($input, $id){
        $model = News::find($id);
        $model->fill($input)->save();
        $foreign_ids = [];
        if(isset($input['main_image'])){
            foreach($this->foreignToArray($input['main_image']) as $foreign){
                $foreign_ids[] = $foreign['id'];
            }
        }
        if(isset($input['sub_image'])){
            foreach($this->foreignToArray($input['sub_image']) as $foreign){
                $foreign_ids[] = $foreign['id'];
            }
        }
       $model->images()->sync($foreign_ids);

        
        return $model;
    }

    public function delete($id){
        $model = News::find($id);
        $model->delete();
        
    }

}