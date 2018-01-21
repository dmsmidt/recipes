<?php namespace App\Admin\Form;

use Recipe;
use AdminRequest;
use Route;
use DB;

class FormField {

    protected $recipe;
    public $module;
    public $properties;

    public function get($input,$props){
        //if($input == 'multiGroupedCheckbox'){dd($props);}
        $_field = __NAMESPACE__.'\\'.studly_case($input);
        return new $_field($props);
    }

    public function build($props){
        $input_class = (new \ReflectionClass($this))->getShortName();
        $this->module = AdminRequest::module();
        $this->recipe = Recipe::get(AdminRequest::recipe());

        /*if($input_class == 'MultiGroupedCheckbox'){
            dd($props);
        }*/

        //define the field label
        $this->properties['label'] = isset($props['label']) ? $props['label'] : null;

        //define the field name
        $this->properties['name'] = isset($props['name']) ? $props['name'] : null;

        //get the default value of the form field according to recipe if set
        $default = isset($this->recipe->fields[$this->properties['name']]['default']) ? $this->recipe->fields[$this->properties['name']]['default'] : null;

        //set the fields value if known or put a default value if set
        $this->properties['value'] = isset($props['value']) ? $props['value'] : $default;

        //disable the field if set disabled
        $this->properties['disabled'] = isset($props['disabled']) ? $props['disabled'] : null;

        //maxfiles and maxsize for images fields
        $this->properties['maxfiles'] = isset($props['maxfiles']) ? $props['maxfiles'] : null;
        //maxsize for images fields
        $this->properties['maxsize'] = isset($props['maxsize']) ? $props['maxsize'] : null;
        
        //active languages for
        $this->properties['active_languages'] = isset($props['active_languages']) ? $props['active_languages'] : null;

        //set the fields id equal as name
        $this->properties['id'] = $this->properties['name'];

        //get the options for the form field according to recipe if set
        $options = isset($this->recipe->fields[$this->properties['name']]['options']) ? $this->recipe->fields[$this->properties['name']]['options'] : [];
        if(count($options)){
            $this->properties['options'] = [];
            //options withdrawn from table
            if(array_key_exists('table',$options)){
                $table = $options['table'];
                $text = $options['text'];
                $value = $options['value'];

                //if the items need to be grouped for multiple checkbox or radio groups
                if(array_key_exists('group_by',$options) && !empty($options['group_by'])){

                    //if a dot exists in the string the options are grouped by a field in a related table
                    if(strpos($options['group_by'],'.') !== false){
                        $arrRelation = explode('.',$options['group_by']);
                        $rel_table = $arrRelation[0];
                        $rel_field = $arrRelation[1];
                        $id = str_singular($rel_table).'_id';
                        //setup filter if it exists
                        $where = '';
                        if(isset($options['filter_by']) && !empty($options['filter_by'])){
                            $filterArr = explode(' = ',$options['filter_by']);
                            $filterFindArr = explode('.',$filterArr[0]);
                            $filterFindIn = $filterFindArr['0'];
                            $filterFindWhat = $filterFindArr['1'];
                            $filterFindEqual = $filterArr['1'];
                            // works only if the referenced table is the same as the related table
                            if($rel_table == $filterFindIn){
                                $where = "WHERE ".$rel_table.".".$filterFindWhat." = '".$filterFindEqual."'";
                            }
                        }
                        /**
                         * @todo this query should not be here. Move is to a repository class.
                         * If the recipe has a field with a grouped input this query(below) should be added to the repository of the recipe
                         * Add groupAndFilterBy method to the repository
                         */
                        $result = DB::select(DB::raw("SELECT ".$rel_table.".".$rel_field." AS 'group_name', ".$table.".".$text." AS 'text', ".$table.".".$value." AS 'value'
                                              FROM ".$rel_table."
                                              INNER JOIN ".$table." ON ".$rel_table.".id = ".$table.".".$id."
                                              ".$where."
                                              ORDER BY ".$rel_table.".".$rel_field.", ".$table.".".$text.""));
                        foreach($result as $row){
                            if(is_array($this->properties['value'])){
                                if(isset($this->properties['value']) && in_array($row->value,$this->properties['value'])){
                                    $checked = 'checked';
                                }else{
                                    $checked = '';
                                }
                            }else{
                                if(isset($this->properties['value']) && $this->properties['value'] == '1'){
                                    $checked = 'checked';
                                }else{
                                    $checked = '';
                                }
                            }
                            $this->properties['options'][$row->group_name][] = [
                                "label" => $row->text,
                                "name" => $table.'.'.$row->text,
                                "id" => $row->value,
                                "value" => $checked,
                                "class" => "locker"
                            ];
                        }
                    }else{
                        /**
                         * @todo build a group and filter feature for local table (no dots(.) in the group_by)
                         * The group_by value will represent a column name inside the table
                         * The filter_by value will represent column name = value
                         */
                    }
                }else{
                    $result = DB::select(DB::raw("SELECT ".$value.",".$text." FROM ".$table." ORDER BY ".$text));
                    foreach($result as $option){
                        $this->properties['options'][$option->$value] = $option->$text;
                    }
                    //in case of role selection filter out certain options at certain user roles
                    if(\Session::get('user.role_id') > 1 && $this->module == 'users'){
                        unset($this->properties['options'][1]);
                    }
                    //if an empty selection is needed
                    if(isset($options['null_option']) && $options['null_option']){
                        $this->properties['options'][0] = '';
                    }
                }

            }else{
                //options from array
                foreach($options as $option){
                    $this->properties['options'][$option['value']] = $option['text'];
                }
            }
        }

        //set the error key of the form field, needed to show the validation error with equal key
        $this->properties['error'] = $this->properties['name'];

        //Determine if the field is required to mark the field label
        $rules = $this->recipe->rules();

        //If the field is required set required
        if(array_key_exists($this->properties['name'],$rules)){
            $this->properties['required'] = (strpos($rules[$this->properties['name']],'required') !== false) ? true : false;
        }
        //Remove required mark when it is a password field and action is edit
        $action_arr = explode('@',Route::current()->getActionName());
        if($input_class == 'Password' && $action_arr[1] == 'edit'){
            $this->properties['required'] = false;
        }

        //add extra classes
        $this->properties['class'] = isset($props['class']) ? $props['class'] : null;

        //add flag
        $this->properties['language'] = isset($props['language']) ? $props['language'] : null;


    }

} 