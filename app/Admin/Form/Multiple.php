<?php namespace App\Admin\Form;

//Todo: Generating a disabled multiple input

use Recipe;
use CmsForm as SubForm;
use Lang;

class Multiple extends CmsFormField{

    public $rel_recipe;
    public $relation;
    public $table;
    public $reference;
    public $parent_id;
    public $items;

    public function __construct($moduleName, $label, $name, $value, $disabled){
        parent::__construct($moduleName, $label, $name, $value, $disabled);

        $this->rel_recipe = Recipe::get($name);
        if(isset($this->recipe->has_many)){
            if(array_key_exists($name,$this->recipe->has_many)){
                $this->relation = 'has_many';
                $ref = explode('.',$this->recipe->has_many[$name]);
                $this->table = $ref[0];
                $this->reference = $ref[1];
            }
        }elseif(isset($this->recipe->many_many)){
            if(array_key_exists($name,$this->recipe->many_many)){
                $this->relation = 'many_many';
                $ref = explode('.',$this->recipe->many_many[$name]);
                $this->table = $ref[0];
                $this->reference = $ref[1];
            }
        }
        $this->parent_id = $value;
        $this->items = $this->selectItems();
    }
    /**
     * Select the multiple items from the database
     * @return mixed
     */
    private function selectItems(){
        $table = $this->table;
        $id = $this->parent_id;
        $query = \DB::table($table)->where($this->reference,'=',$id);
        if($this->rel_recipe->sortable){
            $query->orderBy($table.'.index');
        }
        return $query->get();
    }

    public function view()
    {
        return $this->name;
    }

    public function input()
    {
        $data = [
            "name" => $this->name,
            "label" => Lang::get($this->moduleName.'.'.$this->label),
            "label_extra" => null,
            "value" => null,
            "error" => null,
            "input_extra" => null,
            "add" => $this->rel_recipe->add,
            "headers" => $this->getColHeaders(),
            "add_form" => $this->addForm(),
            "sortable" => $this->rel_recipe->sortable,
            "rows" => $this->getRows(),
        ];
        return \View::make('cms.form.multiple',['field' => $data])->render();
    }

    /**
     * Define column headers of the multiple items overview
     * @return array
     */
    private function getColHeaders(){
        $summary = $this->rel_recipe->summary;
        $headers = [];
        $n = 0;
        foreach($summary as $field)
        {
                $headers[$n]['type'] = $this->rel_recipe->fields[$field]['input'];
                $headers[$n]['text'] = $this->rel_recipe->fields[$field]['label'];
            $n++;
        }
        return $headers;
    }

    /**
     * Generate the view data collection for each item
     * @return array
     */
    private function getRows(){
        $rows = [];
        foreach($this->items as $row){
            $rows[] = $this->makeRow($row);
        }
        return $rows;
    }

    /**
     * Collect view data for an item
     * @param $index
     * @param null $data
     * @return mixed
     */
    public function makeRow($data = null){
        //dd($data);
        $summary = $this->rel_recipe->summary;
        $cols = [];
        $c = 0;
        foreach($summary as $summary_field){
            $input = $this->rel_recipe->fields[$summary_field]['input'];
            $cols[$c]['field']['type'] = $input;
            $cols[$c]['field']['name'] = $summary_field;
            $cols[$c]['field']['value'] = SubForm::$input($this->moduleName, $data->id, $summary_field ,$data->$summary_field)->view();
            $c++;
        }
        $options = $this->getRowOptions();

        if((isset($this->rel_recipe->activatable) && $this->rel_recipe->activatable) && isset($data)){
            $options[] = [
                'id' => $data->id,
                'class' => 'btnActive',
                'title' => 'On/Off switch',
                'icon' => $data->active ? 'icon-active' : 'icon-inactive'
            ];
        }
        if((isset($this->rel_recipe->protectable) && $this->rel_recipe->protectable) && isset($data)){
            $options[] = [
                'id' => $data->id,
                'class' => 'btnProtect',
                'title' => 'Protection On/Off',
                'icon' => $data->protect ? 'icon-lock' : 'icon-unlock'
            ];
        }

        $row = [
            "modulename" => $this->name,
            "sortable" => isset($this->rel_recipe->sortable) && $this->rel_recipe->sortable ? true : false,
            "id" => $data->id,
            "cols" => $cols,
            "options" => $options,
            "item_form" => $this->form($data)
        ];
        //dd($row['item_form']);
        return \View::make('cms.form.multiplerow',['row' => $row])->render();
    }

    /**
     * Build option collection for item buttons
     * @param $moduleName
     * @param $index
     * @return array
     */
    private function getRowOptions()
    {
        $options = [
            0 => [
                "title" => "edit ".str_singular($this->moduleName),
                "icon" => "icon-edit",
                "class" => "btnMultipleEdit",
            ],
            1 => [
                "title" => "delete ".str_singular($this->moduleName),
                "icon" => "icon-delete",
                "class" => "btnMultipleDelete"
            ],
        ];
        return $options;
    }

    /**
     * @param null $data
     * @return mixed
     */
    private function form($data = null){

        $fields = $this->rel_recipe->fields;
        $formfields = [];
        foreach($fields as $name => $field){
            if(isset($field['input'])&&!empty($field['input'])){
                $fieldname = isset($data) ? $this->name.'['.$data->id.']['.$name.']' : $this->name.'[0]['.$name.']';
                $label = isset($field['label']) ? $field['label'] : null;
                $value = isset($data) ? $data->$name : '';
                $disabled = isset($data) ? false : true;
                $Input = SubForm::$field['input']($this->name, $label, $fieldname, $value, $disabled)->input();
                $formfields[$name]['field'] = $Input;
            }
        }

        $form['formfields'] = $formfields;
        //dd($form['formfields']);
        return $form;
    }

    /**
     * @return mixed
     */
    private function addForm(){
        $relation = Recipe::get($this->moduleName)->has_many[$this->name];
        $id_field = substr($relation,strpos($relation,'.')+1);
        $fields = $this->rel_recipe->fields;
        $formfields = [];
        foreach($fields as $name => $field){
            if(isset($field['input'])&&!empty($field['input'])){
                $fieldname = $this->name.'[0]['.$name.']';
                $label = isset($field['label']) ? $field['label'] : null;
                $value = $name == $id_field ? $this->parent_id : '';
                $disabled = true;
                $Input = SubForm::$field['input']($this->name, $label, $fieldname, $value, $disabled)->input();
                $formfields[$name]['field'] = $Input;
            }
        }
        $form['formfields'] = $formfields;
        return $form;
    }

}
