<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IImageRepository;
use App\Models\Image;

class ImageRepository extends BaseRepository implements IImageRepository{

    public function selectAll(){
        return Image::all()->toArray();
    }

    public function SelectById($id){
        return Image::find($id);
    }

    public function add($input){
        $model = new Image;
        $model->fill($input)->save();
        return $model;
    }

    public function update($input, $id){
        $model = Image::find($id);
        $model->fill($input)->save();
        return $model;
    }

    public function delete($id){
        $model = Image::find($id);
        $dir_name = $model->image_template;
        $this->deleteImage($model);
        $model->delete();
    }

}