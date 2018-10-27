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
     */
    public function saveTranslations($moduleName, $input){
        //get active languages
        $languages = Session::get('language.active');
        $fields = \Recipe::get($moduleName)->languageFields();
        $_langModel =  '\\App\\Models\\'.studly_case($moduleName).'Lang';
        $related_field =  str_singular($moduleName).'_id';
        foreach($languages as $arrLang){
            $lang = $_langModel::firstOrNew([$related_field => $input['id'], "language_id" => $arrLang['id']]);
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
     * @param $image
     */
    public function deleteImage($image){
        $uploads_path = base_path().'/storage/app/public/uploads/';
        if(file_exists($uploads_path.$image->image_template)){
            $image_paths = array_diff(scandir($uploads_path.$image->image_template), array('..', '.'));
            foreach($image_paths as $path){
                if(file_exists($uploads_path.$image->image_template.'/'.$path.'/'.$image->filename)){
                    unlink($uploads_path.$image->image_template.'/'.$path.'/'.$image->filename);
                }
            }
            if(file_exists($uploads_path.$image->filename)){
                unlink($uploads_path.$image->filename);
            }
        }
    }

    /**
     * Converts associative array of multiple fields to a numeric key array with field
     * collections and their values
     * @param $input
     * @return array
     */
    public function foreignToArray($input){
        $multiple_input = [];
        $array_keys = array_keys($input);
        foreach($array_keys as $fieldname){
            $n = 0;
            foreach($input[$fieldname] as $value){
                $multiple_input[$n][$fieldname] = $value;
                $n++;
            }
        }
        return $multiple_input;
    }
}