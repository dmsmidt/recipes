<?php namespace App\Admin\Repositories;

//use App\Models\Language;
use Session;
//use App\Models\Image;
//use Illuminate\Support\Facades\File;

class BaseRepository {

    /**
     * Saving the translations of a related language model of an incoming request.
     * @param $moduleName
     * @param $input
     * @param $id
     */
    public function saveTranslations($moduleName, $input, $id){
        //get active languages
        $languages = Session::get('language.active');
        $fields = \Recipe::get($moduleName)->languageFields();
        $_langModel =  '\\App\\Models\\'.studly_case($moduleName).'Lang';
        $related_field =  str_singular($moduleName).'_id';
        foreach($languages as $arrLang){
            $lang = $_langModel::firstOrNew([$related_field => $id, "language_id" => $arrLang['id']]);
            foreach($fields as $field){
                if(isset($input[$field]) && !empty($input[$field])){
                    $lang->$field = \Session::get('language.default_id') == $arrLang['id'] ? $input[$field] : $input[$field.'_'.$arrLang['abbr']];
                }else{
                    $lang->$field = '';
                }
            }
            $lang->save();
        }
    }

    /**
     * Delete translations.
     * @param $moduleName
     * @param $id
     */
    public function deleteTranslations($moduleName, $id){
        $_langModel =  '\\App\\Models\\'.studly_case($moduleName).'Lang';
        $related_field =  str_singular($moduleName).'_id';
        $translations = $_langModel::where($related_field, $id);
        $translations->delete();
    }

    /**
     * Deleting related images and language
     * @param $images
     */
    public function deleteImages($images){
        foreach($images as $image){
            $model = Image::find($image->id);
            $uploads_path = base_path().'/public_html/uploads/';
            $image_paths = array_diff(scandir($uploads_path.$model->template), array('..', '.'));
            foreach($image_paths as $path){
                unlink($uploads_path.$model->template.'/'.$path.'/'.$model->filename);
            }
            unlink($uploads_path.$model->filename);
            $model->alt()->delete();
            $model->delete();
        }
    }

}