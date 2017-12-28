<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ILanguageRepository;
use App\Models\Language;

class LanguageRepository extends BaseRepository implements ILanguageRepository{

    public function selectTree(){
        return Language::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return Language::find($id);
    }

    public function add($input){
        $model = new Language;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Language::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Language::find($id);
        $model->delete();
        
    }

    public function defaultLanguage(){
        return \App\Models\Language::where('default',1)->get()->first();
    }

    public function userLanguage($user){
        return Language::where('abbr',$user->language)->get()->first();
    }

    public function activeLanguage(){
        return Language::active();
    }
}