<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Routing\Route;
use AdminRequest;
use DB;
use Recipe;
use Lang;
use CmsForm;
use Session;

class MainComposer {

    protected $moduleName;
    protected $action;
    protected $uri;
    protected $lang;
    protected $role_id;

    public function __construct(Route $route){
        $this->moduleName = AdminRequest::module();
        $this->action = AdminRequest::action();
        $this->uri = AdminRequest::path();
    }

    /**
     * Bind data to the view.
     * @param  View  $view
     * @return void
     */
    public function compose(View $view){
        $view->with('topbar', $this->topBar($view))
             ->with('mainmenu', $this->menu())
             ->with('bottombar',$this->bottomBar())
             ->with('plugins', $this->plugins($view));
    }

    public function menu(){
        $menu = DB::select(DB::raw("SELECT menu_items_roles.menu_item_id, menu_items.name, menu_items.icon, menu_items.url, menu_items_lang.text ,IF(name = '".$this->moduleName."',1,0) AS `current`
                                      FROM menu_items_roles
                                      INNER JOIN menu_items ON(menu_items_roles.menu_item_id = menu_items.id)
                                      LEFT JOIN menu_items_lang ON(menu_items_lang.menu_item_id = menu_items.id AND menu_items_lang.language_id = ".\Session::get('language.user_lang_id').")
                                      WHERE menu_items_roles.role_id = ".\Session::get('user.role_id')." AND menu_items.menu_id = 1 AND menu_items.active = 1 ORDER BY menu_items.lft"));
        return $menu;
    }

    /**
     * Generate the topbar
     * @param $view
     * @return object
     */
    public function topBar($view){
        $top_bar = [];

        //show/hide the add button
        if(strpos($this->action,'create') === false && strpos($this->action,'edit') === false){
            $recipe = Recipe::get($this->moduleName);
            if((isset($recipe->add) && $recipe->add) || ($this->moduleName == 'recipes')){
                $top_bar['buttons'][] = [
                    "text" => Lang::get('admin.Add'),
                    "icon" => "fa-plus",
                    "classes" => "btnAdd big_button",
                    "href" => "/".$this->uri."/create"
                ];
            }
        }
        if(isset($view->getData()['topbar_buttons'])){
            $top_bar['buttons'] = array_merge($top_bar['buttons'], $view->getData()['topbar_buttons']);
        }

        //define the topbar title
        //dd($this);
        if(AdminRequest::hasChilds()){
            $child_module = AdminRequest::childModule();
            $repository = 'App\\Admin\\Repositories\\'.str_singular(studly_case($this->moduleName)).'Repository';
            $repo = new $repository;
            $module_item_id = AdminRequest::moduleItemId();
            $model = $repo->selectById($module_item_id);
            $parent_name = $model->name;
            $top_bar["title"] = Lang::get($this->moduleName.'.'.ucfirst($this->moduleName)).' '.$parent_name.': '.ucfirst(str_replace('_',' ',$child_module));
        }else{
            $top_bar["title"] = Lang::get($this->moduleName.'.'.ucfirst($this->moduleName));
        }


        //define related child title if creating or editing a child item
        if(AdminRequest::hasChilds()){
            $top_bar["sub_title"] = AdminRequest::recipe();
        }
        //select the active languages to show the flag buttons
        $active_languages = Session::get('language.active');
        $top_bar['languages'] = [];
        if(count($active_languages)){
            $top_bar['languages'] = $active_languages;
        }
        return (object)$top_bar;
    }

    /**
     * Generate the bottombar
     * @return null|object
     */
    public function bottomBar(){
        $bottom_bar = [];
        if($this->action == 'create' ||
           $this->action == 'edit'){
            $arr_path = AdminRequest::segments();
            if($arr_path[count($arr_path)-1] == 'edit'){
                $return = '/'.implode('/',array_slice($arr_path,0,count($arr_path)-2));
            }else{
                $return = '/'.implode('/',array_slice($arr_path,0,count($arr_path)-1));
            }
            $bottom_bar['save'] = [
                "href" => "javascript: $('form').submit()"
            ];
            $bottom_bar['cancel'] = [
                "href" => $return
            ];
        }else{
            return null;
        }
        return (object)$bottom_bar;
    }

    /**
     * Adding js or css files to include in the view
     * @param $view
     * @return array
     */
    public function plugins($view){
        $plugins['javascript'] = [];
        $plugins['css'] = [];
        if(isset($view->javascripts)){
            //get javascripts added to the view earlier
            foreach($view->javascripts as $javascript){
                $plugins['javascript'][] = $javascript;
            }
        }
        if(isset($view->css)){
            //get style sheets added to the view earlier
            foreach($view->css as $css){
                $plugins['css'][] = $css;
            }
        }
        //get javascript and css plugins from the recipes inputs
        $recipe = Recipe::get($this->moduleName);
        $recipe_plugins = $recipe->plugins();
        //if language inputs exists in the recipe, get the inputs from the related language recipe
        if($recipe->hasTranslations()){
            $lang_plugins = Recipe::get($this->moduleName.'_lang')->plugins();
            $plugins = array_merge_recursive($plugins,$recipe_plugins,$lang_plugins);
        }else{
            $plugins = array_merge_recursive($plugins,$recipe_plugins);
        }
        return $plugins;
    }
}