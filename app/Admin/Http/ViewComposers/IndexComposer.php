<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Routing\Route;
use AdminRequest;
use Recipe;
use FormField;

class IndexComposer {

    protected $module;
    protected $childRecipe;
    protected $parent_id;
    protected $recipe;
    protected $data;
    /*protected $items;*/
    protected $levels;

    public function __construct(Route $route){
        $this->module = AdminRequest::module();
        if(AdminRequest::hasChilds()){
            $this->childRecipe = AdminRequest::recipe();
            $this->parent_id = AdminRequest::segments()[2];
        }else{
            $this->childRecipe = null;
            $this->parent_id = null;
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view){
        $this->data = $view->data;
        $this->recipe = isset($this->childRecipe) ? Recipe::get($this->childRecipe) : Recipe::get($this->module);

        //define the nesting levels if sortable or nestable
        if($this->recipe->sortable){
            $this->levels = 1; // a sortable has always one level
        }elseif($this->recipe->nestable){
            // a nestable has always a parent which is retrieved here
            $parent_recipe = Recipe::get($this->module);
            // select the parent from db
            $parent = \DB::table($parent_recipe->table)->where('id',$this->parent_id)->first();
            if(isset($parent->levels)){
                $this->levels = $parent->levels;
            }else{
                $this->levels = 1;
            }
        }else{
            $this->levels = null;
        }
        $view->with('index',$this->index());
    }

    public function index(){
        $content['headers'] = $this->getHeaders();
        $content['levels'] = $this->levels;
        $content['rows'] = $this->getRows($this->data);
        return (object)$content;
    }

    private function getHeaders(){
        $tableHeaders = [];
        $n = 0;
        if(isset($this->recipe->summary)){
            foreach($this->recipe->summary as $field){
                $tableHeaders[$n]['class'] = $this->recipe->fields[$field]['input'];
                $tableHeaders[$n]['text'] = $this->recipe->fields[$field]['label'];
                $n++;
            }
        }
        return $tableHeaders;
    }

    private function getRows($items, $n = 0){
        $rows = [];
        foreach($items as $item){
            $rows[$n] = $this->buildRow($item);
            if (isset($item['children']) && count($item['children'])) {
                $rows[$n]['children'] = $this->getRows($item['children']);
            }
            $n++;
        }
        return $rows;
    }

    /**
     * @param $row_data
     * @return mixed
     */
    private function buildRow($row_data){
        $summary = $this->recipe->summary;
        $options = $this->recipe->options();
        $cols = [];
        $c = 0;
        $row['id'] = $row_data['id'];
        //needed variables for sortable or nestable rows
        $row['parent_id'] = isset($row_data['parent_id']) ? $row_data['parent_id'] : null;
        $row['lft'] = isset($row_data['lft']) ? $row_data['lft'] : null;
        $row['rgt'] = isset($row_data['rgt']) ? $row_data['rgt'] : null;
        $row['level'] = isset($row_data['level']) ? $row_data['level'] : null;

        if(isset($row_data['is_header']) && $row_data['is_header']){
            $row['class'] = 'parent_row';
        }

        //get the protect value of the row if option exists
        if($options['protectable']){ $row['protect'] = $row_data['protect']; }else{ $row['protect'] = null; }
        //get the active value of the row if option exists
        if($options['activatable']){ $row['active'] = $row_data['active']; }else{ $row['active'] = null; }
        //get the summary columns
        foreach($summary as $field){
            if(array_key_exists($field,$row_data)){
                $type = $this->recipe->fields[$field]['input'];
                $label = array_key_exists('label',$this->recipe->fields[$field]) ? $this->recipe->fields[$field]['label'] : null;
                $cols[$c]['type'] = $type;
                $props = [
                    "name" => $field,
                    "label" => $label,
                    "value" => $row_data[$field]
                ];
                $cols[$c]['value'] = FormField::get($type,$props)->view();
            }
            elseif(isset($this->recipe->has_many) && array_key_exists($field,$this->recipe->has_many)){
                /* in this case the input has multiple related child data
                 * therefore a button is added to the row to open a window
                 * for editing the child data
                 * the value is the parents id
                 */
                $type = $this->recipe->fields[$field]['input'];
                $label = array_key_exists('label',$this->recipe->fields[$field]) ? $this->recipe->fields[$field]['label'] : null;
                $cols[$c]['type'] = $type;
                $props = [
                    "name" => $field,
                    "label" => $label,
                    "value" => $row['id']
                ];
                $cols[$c]['value'] = FormField::get($type,$props)->view();
            }
            $c++;
        }
        $row['columns'] = $cols;
        //define the controller action verb for the possible options
        $actions = ["edit" => "get", "delete" => "delete", "sortable" => "", "nestable" => "", "activatable" => "", "protectable" => ""];
        //define the action urls
        if(isset($this->childRecipe)){
            $edit_url = "/admin/".$this->module."/".$this->parent_id."/".$this->childRecipe."/".$row_data['id']."/edit";
            $delete_url = "/admin/".$this->module."/".$this->parent_id."/".$this->childRecipe."/".$row_data['id'];
        }else{
            $edit_url = "/admin/".$this->module."/".$row_data['id']."/edit";
            $delete_url = "/admin/".$this->module."/".$row_data['id'];
        }
        $urls = [
            "edit" => $edit_url,
            "delete" => $delete_url,
            "sortable" => "",
            "nestable" => "",
            "activatable" => "",
            "protectable" => ""
        ];


        //define row options
        foreach($options as $option => $value){
            $module_name = isset($this->childRecipe) ? $this->childRecipe : $this->module;
            //the add option is filtered out because it has no use in the item row
            if($option !== 'add'){
                if($value){
                    $row[$option] =
                    [
                        "class" => "btn".ucfirst($option),
                        "title" =>  ucfirst($option)." ".str_singular($module_name),
                        "icon" => "fa-".$option,
                        "module_name" => $module_name,
                        "url" => $urls[$option],
                        "action" => $actions[$option]
                    ];
                }
            }
        }
        return $row;
    }

} 