<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ISlideshowRepository;
use App\Models\Slideshow;

class SlideshowRepository extends BaseRepository implements ISlideshowRepository{

    public function selectAll(){
        return Slideshow::all()->toArray();
    }

    public function SelectById($id){
        return Slideshow::find($id);
    }

    public function add($input){
        $model = new Slideshow;
        $model->fill($input)->save();
        $foreign_ids = [];
        foreach($this->multipleToArray($input) as $foreign){
           $foreign_ids[] = $foreign['id'];
        }
        $model->images()->sync($foreign_ids);
        return $model;
    }

    public function update($input, $id){
        //dd($input);
        $model = Slideshow::find($id);
        $model->fill($input)->save();
        $foreign_ids = [];
        foreach($this->multipleToArray($input) as $foreign){
           $foreign_ids[] = $foreign['id'];
        }
        $model->images()->sync($foreign_ids);
        return $model;
    }

    public function delete($id){
        $model = Slideshow::find($id);
        $model->delete();
    }

}