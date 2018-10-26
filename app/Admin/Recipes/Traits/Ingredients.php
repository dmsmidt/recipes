<?php

namespace App\Admin\Recipes\Traits;

/**
 * Trait Ingredients
 * @package App\Admin\Recipes\Traits
 * Methods for returning parts of the recipe as ingredients
 */

trait Ingredients {

    /**
     * Return array with field:rules pairs
     * @param $id
     * @return array
     */
    public function rules($id = null){
        $rules = [];
        foreach($this->fields as $name => $data){
            if(isset($data['rule'])){
                $rules[$name] = $data['rule'];
                if(strpos($data['rule'],'unique:'.$this->moduleName) !== false && isset($id)){
                    $rules[$name] .= ','.$name.','.$id;
                }
            }
        }
        return $rules;
    }

    /**
     * Returns array with possible foreign type fields (related data)
     * @return array
     */
    public function foreign(){
        $related = [];
        foreach($this->fields as $name => $data){
            if(isset($data['type']) && $data['type'] == 'foreign'){
                $related[] = $name;
            }
        }
        return $related;
    }

    /**
     * Returns array with recipe main options
     * @return mixed
     */
    public function options(){
        $options['add'] = $this->add;
        $options['edit'] = $this->edit;
        $options['delete'] = $this->delete;
        $options['sortable'] = $this->sortable;
        $options['nestable'] = $this->nestable;
        $options['activatable'] = $this->activatable;
        $options['protectable'] = $this->protectable;
        return $options;
    }

    /**
     * Returns an array of the used input types
     * @return array
     */
    public function inputs(){
        $inputs = [];
        if(isset($this->fields)){
            //walk through recipe fields
            foreach($this->fields as $props){
                if(isset($props['input'])){
                    if(!in_array($props['input'],$inputs)){
                        $inputs[] = $props['input'];
                    }
                }
            }
            return $inputs;
        }
        return [];
    }

    /**
     * Returns array with language related fields
     * @return array
     */
    public function languageFields(){
        $fields = [];
        foreach($this->fields as $name => $data){
            if(array_key_exists('type',$data) && $data['type'] == 'translation'){
                $fields[] = $name;
            }
        }
        return $fields;
    }

    /**
     * Checks if the recipe contains language inputs
     * @return bool
     */
    public function hasTranslations(){
        return in_array('language', $this->inputs());
    }

    /**
     * Selects the needed plugins for the input fields
     * @return mixed
     */
    public function plugins(){
        $plugins['javascript'] = [];
        $plugins['css'] = [];
        foreach($this->inputs() as $input){
            $input = 'App\\Admin\\Form\\'.studly_case($input);
            $input_class = new $input([]);
            if(isset($input_class->plugins)){
                $_plugins = $input_class->plugins;
                if(isset($_plugins['css'])){
                    foreach($_plugins['css'] as $css){
                        $plugins['css'][] = $css;
                    }
                }
                if(isset($_plugins['javascript'])){
                    foreach($_plugins['javascript'] as $javascript){
                        $plugins['javascript'][] = $javascript;
                    }
                }
            }
        }
        return $plugins;
    }

    public function hasParent(){
        if(isset($this->parent) && !empty($this->parent)){
            return true;
        }
        return false;
    }

    public function imageInputFields(){
        $inputs = $this->inputs();
        if(in_array('image',$inputs) || in_array('images',$inputs)){
            $field_names = [];
            foreach($this->fields as $name => $field){
                if(isset($field['input']) && ($field['input'] == 'image') || $field['input'] == 'images'){
                    $field_names[] = $name;
                }
            }
            return $field_names;
        }
        return [];
    }

    /**
     * returns an array with tables or foreign image field names to join the model
     * @return array
     */
    public function with(){
        $with = [];
        /**
         * select the tables to join
         */
        if(isset($this->has_one) && count($this->has_one)){
            foreach($this->has_one as $value){
                if(array_key_exists('with',$value) && $value['with'] == true){
                    $with[] = $value['table'];
                }
            }
        }
        if(isset($this->has_many) && count($this->has_many)){
            foreach($this->has_many as $value){
                if(array_key_exists('with',$value) && $value['with'] == true){
                    $with[] = $value['table'];
                }
            }
        }
        if(isset($this->many_many) && count($this->many_many)){
            foreach($this->many_many as $value){
                if(array_key_exists('with',$value) && $value['with'] == true){
                    $with[] = $value['table'];
                }
            }
        }
        /**
         * select the foreign image field names
         */
        $fields = $this->imageInputFields();
        if(is_array($fields) && count($fields)){
            foreach($fields as $field){
                $with[] = $field;
            }
        }
        return $with;
    }

} 