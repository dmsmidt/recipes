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

    public function selectByTemplate($template){
        return ImageFormat::where('image_template', $template)->get();
    }

    public function selectByImage($template, $id){
        $format = ImageFormat::where('image_template', $template)->where('image_id', $id)->get();
        if($format->count()){
            return $format;
        }else{
            return ImageFormat::where('image_template', $template)->get();
        }
    }

}