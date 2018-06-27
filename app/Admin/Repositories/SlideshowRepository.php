<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ISlideshowRepository;
use App\Models\Slideshow;
use App\Models\Image;

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
        return $model;
    }

    public function update($input, $id){
        $model = Slideshow::find($id);
        $model->fill($input)->save();
        foreach($this->multipleToArray($input) as $image){
            if(isset($image['id'])){
                $model->images()->attach($image['id']);
            }
        }
        return $model;
    }

    public function delete($id){
        $model = Slideshow::find($id);
        $model->delete();
        
    }

}