<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IImagesLangRepository;
use App\Models\ImagesLang;

class ImagesLangRepository extends BaseRepository implements IImagesLangRepository{

    public function selectAll(){
        return ImagesLang::all()->toArray();
    }

    public function SelectById($id){
        return ImagesLang::find($id);
    }

    public function add($input){
        $model = new ImagesLang;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = ImagesLang::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = ImagesLang::find($id);
        $model->delete();
        
    }

}