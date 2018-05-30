<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Routing\Route;
use App\Admin\Http\Requests\AdminRequest;
use Recipe;
use FormField;


class IndexComposer {

    protected $admin_request;
    protected $module;
    protected $childRecipe;
    protected $parent_id;
    protected $recipe;
    protected $data;
    protected $levels;

    public function __construct(Route $route, AdminRequest $adminRequest){
        $this->admin_request = $adminRequest;
        $this->module = $adminRequest->module();
        if($adminRequest->hasChilds()){
            $this->childRecipe = $adminRequest->recipe();
            $this->parent_id = $adminRequest->segments()[2];
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
            $parent = \DB::table($parent_recipe->moduleName)->where('id',$this->parent_id)->first();
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

    /**
     * Compose the index with headers and item rows
     * @return object
     */
    public function index(){
        $content['headers'] = $this->getHeaders();
        $content['levels'] = $this->levels;
        $content['rows'] = $this->getRows($this->data);
        return (object)$content;
    }

    /**
     * Compose the headers for the index overview
     * @return array
     */
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

    /**
     * Compose the item rows
     * @param $items
     * @param int $n
     * @return array
     */
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
     * Compose the row with option buttons
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

        // A boolean is_header is used to show header rows in the index view
        if(isset($row_data['is_header']) && $row_data['is_header']){
            $row['class'] = 'parent_row';
        }

        //get the protect value of the row if option exists
        if($options['protectable']){ $row['protect'] = $row_data['protect']; }else{ $row['protect'] = null; }
        //get the active value of the row if option exists
        if($options['activatable']){ $row['active'] = $row_data['active']; }else{ $row['active'] = null; }

        //get the summary columns
        foreach($summary as $field){
            //$cols[$c]['value'] = FormField::get($input, $this->getProperties($field))->view();
            if(array_key_exists($field,$row_data)){
                $field_data = $this->recipe->fields[$field];
                $cols[$c]['input'] = $field_data['input'];

                /* @TODO: place below code inside FormField::getProperties()
                if($input == 'foreign'){
                    $props['value'] = $row_data['id'];
                }else{
                    $props['value'] = $row_data[$field];
                }
                */

                /**
                 * Generate the summary field
                 */
                $props = FormField::getProperties($field_data, $field, $row_data);
                $cols[$c]['value'] = FormField::get($props)->view();
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