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
     * Returns array with possible foreign fields (related data)
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
            if(array_key_exists('input',$data) && $data['input'] == 'language'){
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
            $input_class = 'App\\Admin\\Form\\'.studly_case($input);
            $_input = new $input_class;
            if(isset($_input->plugins)){
                foreach($_input->plugins['css'] as $css){
                    $plugins['css'][] = $css;
                }
                foreach($_input->plugins['javascript'] as $javascript){
                    $plugins['javascript'][] = $javascript;
                }
            }
        }
        return $plugins;
    }

    public function hasParent(){
        if(isset($this->parent_table) && !empty($this->parent_table)){
            return true;
        }
        return false;
    }

} 