<?php namespace App\Admin\Form;

use Auth;
use DB;
use App\Models\Language as LangModel;
use Session;


class Language{

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
        return $this;
    }

    public function view()
    {
        /*$translate_tabel = $this->properties['moduleName'].'_lang';
        $relation = str_singular($this->properties['moduleName']).'_id';
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
        }*/
    }

    public function input()
    {
        /**
         * Select the active languages
         */
        $input = '';
        //loop through different translations of the value
        foreach(Session::get('language.active') as $lang){
            //hidden fields
            if(isset($this->properties['value']) && is_object($this->properties['value']) && count($this->properties['value'])){
                foreach($this->properties['value'] as $value){
                    if($value->language_id == $lang['id']){
                        $properties_hidden = [
                            "name" => $this->properties['name'] . '_' . $lang['abbr'],
                            "value" => $value->{$this->properties['name']},
                            "class" => 'language'
                        ];
                        if(Session::get('language.default_id') == $lang['id']){
                            $properties_default = [
                                "label" => $this->properties['label'],
                                "name" => $this->properties['name'],
                                "value" => $value->{$this->properties['name']},
                                "disabled" => $this->properties['disabled'],
                                "id" => $this->properties['name'],
                                "error" => $this->properties['name'],
                                "required" => $this->properties['required'],
                                "class" => $this->properties['class'].' translation',
                                "language" => true,
                            ];
                        }
                    }
                }
            }else{
                $properties_hidden = [
                    "name" => $this->properties['name'] . '_' . $lang['abbr'],
                    "value" => null,
                    "class" => 'language'
                ];
                if($lang['default']) {
                    $properties_default = [
                        "label" => $this->properties['label'],
                        "name" => $this->properties['name'],
                        "value" => null,
                        "disabled" => $this->properties['disabled'],
                        "id" => $this->properties['name'],
                        "error" => $this->properties['name'],
                        "required" => $this->properties['required'],
                        "class" => $this->properties['class'].' translation',
                        "language" => true,
                    ];
                }
            }
            $input .= view('form.hidden',['field' => $properties_hidden])->render();
        }
        $input .= view('form.' . $this->properties['form_input'], ['field' => $properties_default])->render();
        return $input;
    }




}