<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use FormField;
use Request;
use Recipe;
use Lang;


class SettingsComposer {

    protected $moduleName = 'settings';
    protected $recipe;
    protected $data;
    protected $levels = 1;

    public function __construct(Route $route){
        $this->recipe = Recipe::get('settings');
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->data = $view->data;
        $view->with('index',$this->index());
    }

    private function index(){
        $content['rows'] = $this->getRows($this->data);
        return (object)$content;
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
     * Build settings row with configuration data
     * @param $row_data
     * @return mixed
     */
    private function buildRow($row_data){
        $cols = [];
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
        $row['protect'] = null;
        //get the active value of the row if option exists
        $row['active'] = null;

        /**
         * Label column for setting name
         */
        $cols[0]['input'] = 'text';
        $props = [
            "name" => null,
            "label" => null,
            "value" => $row_data['label']
        ];
        $cols[0]['value'] = Lang::get('settings.'.FormField::get('text',$props)->view());

        /**
         * Column with setting values
         */
        $cols[1]['input'] = $row_data['input_type'];
        $props = [
            "name" => $row_data['name'],
            "label" => null,
            "value" => isset($row_data['value']) ? $row_data['value'] : null
        ];

        $cols[1]['value'] = '';
        if(!$row_data['is_header']){
            $cols[1]['value'] = FormField::get($row_data['input_type'], $props)->view();
        }
        $row['columns'] = $cols;

        //define row options if not a header row
        if(!isset($row_data['is_header']) || !$row_data['is_header']){
            $row['edit'] =
            [
                "class" => "btnEdit",
                "title" =>  "Edit settings",
                "icon" => "icon-edit",
                "module_name" => "settings",
                "url" => "/admin/settings/".$row_data['id']."/edit",
                "action" => "get"
            ];
        }
        return $row;
    }


}