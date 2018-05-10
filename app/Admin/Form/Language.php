<?php namespace App\Admin\Form;

use Auth;
use DB;
use App\Models\Language as LangModel;
use Session;


class Language extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
    }

    public function view()
    {
        $translate_tabel = $this->recipe->moduleName.'_lang';
        $relation = str_singular($this->recipe->moduleName).'_id';
        $field = $this->properties['name'];
        $value = $this->properties['value'];
        $translation = DB::select(DB::raw("SELECT ".$field."
                                           FROM ".$translate_tabel."
                                           WHERE ".$relation." = ".$value."
                                           AND language_id = ".\Session::get('language.user_lang_id')));
        if(isset($translation) && count($translation)){
            return $translation[0]->$field;
        }else{
            return null;
        }
    }

    public function input()
    {
        dd($this);
        /**
         * Select the active languages
         */
        $active_languages = Session::get('language.active');
        $input = view('form.language',['field' => $this->properties])->render();
        return $input;
    }

}