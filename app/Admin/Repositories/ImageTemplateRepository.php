<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IImageTemplateRepository;
use App\Models\ImageTemplate;

class ImageTemplateRepository extends BaseRepository implements IImageTemplateRepository{

    public function selectAll(){
        return ImageTemplate::all()->toArray();
    }

    public function SelectById($id){
        return ImageTemplate::find($id);
    }

    public function add($input){
        $model = new ImageTemplate;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = ImageTemplate::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = ImageTemplate::find($id);
        $model->delete();
    }

    public function selectFormatsByName($name){
        return ImageTemplate::where('name', $name)->formats->get();
    }

}