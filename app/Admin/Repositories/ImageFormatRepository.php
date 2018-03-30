<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IImageFormatRepository;
use App\Models\ImageFormat;

class ImageFormatRepository extends BaseRepository implements IImageFormatRepository{

    public function selectAll(){
        return ImageFormat::all()->toArray();
    }

    public function SelectById($id){
        return ImageFormat::find($id);
    }

    public function add($input){
        $model = new ImageFormat;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = ImageFormat::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = ImageFormat::find($id);
        $model->delete();
    }

    public function selectByTemplateId($template_id){
        return ImageFormat::where('image_template_id', $template_id)->get();
    }

}