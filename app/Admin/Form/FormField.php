<?php namespace App\Admin\Form;

use DB;
use Session;
use AdminRequest;
use App\Admin\Services\AdminConfig;


class FormField {

    protected $moduleName;
    protected $properties;

    /*public function get($props){
        $_field = __NAMESPACE__.'\\'.studly_case($props['input']);
        return new $_field($props);
    }*/

    /**
     * @param $field (Recipe->field)
     * @param $name {Name of field)
     * @param $data (Model data)
     * @return array
     */
    public function getProperties($field, $name, $data){
        //dd($data);
        $this->properties = [];
        $Config = new AdminConfig();
        $this->moduleName = AdminRequest::module();

        //moduleName
        $this->properties['moduleName'] = $this->moduleName;

        //get the fields type
        $this->properties['type'] = isset($field['type']) ? $field['type'] : null;

        //get the fields input type
        $this->properties['input'] = $field['input'];

        //define the field label
        $this->properties['label'] = isset($field['label']) ? $field['label'] : null;

        //define the field name
        $this->properties['name'] = isset($name) ? $name : null;

        //get the default value of the form field according to recipe if set
        $default = isset($field['default']) ? $field['default'] : null;

        if($field['input'] == 'foreign' || ( isset($data[$name]) && is_array($data[$name]) )) {
            $this->properties['value'] = $data['id'];
        }elseif(isset($data->value)){
            $this->properties['value'] = $data->value;
        }else{
            $this->properties['value'] = isset($data[$name]) ? $data[$name] : $default;
        }

        //disable the field if set disabled
        $this->properties['disabled'] = isset($field['disabled']) ? $field['disabled'] : null;

        //set the fields id equal as name
        $this->properties['id'] = $this->properties['name'];

        //get the options for the form field according to recipe if set
        $options = isset($field['options']) && !empty($field['options']) ? $field['options'] : [];
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
                         * TODO this query should not be here. Move is to a repository class.
                         * If the recipe has a field with a grouped input this query(below) should be added to the repository of the recipe
                         * Add groupAndFilterBy method to the repository
                         */
                        $result = DB::select(DB::raw("SELECT ".$rel_table.".".$rel_field." AS 'group_name', ".$table.".".$text." AS 'text', ".$table.".".$value." AS 'value'
                                          FROM ".$rel_table."
                                          INNER JOIN ".$table." ON ".$rel_table.".id = ".$table.".".$id."
                                          ".$where."
                                          ORDER BY ".$rel_table.".".$rel_field.", ".$table.".".$text.""));
                        foreach($result as $row){
                            if(is_array($data[$name])){
                                if(isset($this->properties['value']) && in_array($row->value,$data[$name])){
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
                    if(\Session::get('user.role_id') > 1 && $this->moduleName == 'users'){
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

        //special field properties for image and images input
        if($field['input'] == 'images' || $field['input'] == 'image'){
            $this->properties['value'] = isset($data->$name) ? $data->$name : null;
            $this->properties['maxsize'] = $Config->get('max_image_size');
            $this->properties['max_files'] = isset($field['max_files']) ? $field['max_files'] : $data['max_files'];
            $this->properties['image_template'] = isset($field['image_template']) ? $field['image_template'] : $data['image_template'];
            $this->properties['filename'] = isset($data['filename']) ? $data['filename'] : null;
            $this->properties['max_reached'] = false;
            if( isset($this->properties['value']) && !empty($this->properties['value']) ){
                if( isset($this->properties['max_files']) && $this->properties['max_files'] > 0 ){
                    if( count($this->properties['value']) >= $this->properties['max_files']){
                        $this->properties['max_reached'] = true;
                    }
                }else{
                    $this->properties['max_files'] = 1;
                    if( count($this->properties['value']) ){
                        $this->properties['max_reached'] = true;
                    }
                }
            }
            //dd($field,$data, $this->properties);
        }

        //set the error key of the form field, needed to show the validation error with equal key
        $this->properties['error'] = $name;

        //If the field is required set required
        $rules = isset($field['rule']) && !empty($field['rule']) ? $field['rule'] : '';

        $this->properties['required'] = null;
        if(strpos($rules,'required') !== false){
            $this->properties['required'] = true;
        }

        //Remove required mark when it is a password field and action is edit
        $action = AdminRequest::action();
        if($field['input'] == 'password' && $action == 'edit'){
            $this->properties['required'] = null;
        }

        //add extra classes
        $this->properties['class'] = isset($props['class']) ? $props['class'] : null;

        //translations
        $this->properties['language'] = false;
        if($this->properties['type'] == 'translation'){
            $input = $this->properties['input'];
            $this->properties['form_input'] = $input;
            $this->properties['input'] = 'language';
            $this->properties['value'] = $data['language'];
            $this->properties['language'] = true;
        }

        /**
         * Generate hidden id_fields for relationships
         * These fields contain a hidden input and _id in the name
         */
        if($field['input'] == 'hidden' && strpos($name,'_id') !== false && count(AdminRequest::segments()) >= 5){
            $this->properties['value'] = AdminRequest::parent_id();
        }

        return $this->properties;
    }

}