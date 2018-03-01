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
        $this->saveTranslations('images',$input, $model->id);
    }

    public function update($input, $id){
        $model = Image::find($id);
        $model->fill($input)->save();
        $this->saveTranslations('images',$input, $model->id);
    }

    public function delete($id){
        $model = Image::find($id);
        $model->delete();
        $this->deleteTranslations('images',$id);
    }

}