<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Route;
use AdminRequest;
use Recipe;
use FormField;
use Session;
use App\Admin\Services\AdminConfig;


class FormComposer {

    protected $module;
    protected $recipe;
    protected $action; //the basic action (create or edit)
    protected $method; //the form method (POST or PUT)
    protected $url; //the action url of the form
    protected $id; //If model editing, the id is id of the model
    protected $config;

    public function __construct(Route $route){

        /**
         * Define the controller action (edit or create) and request method (POST or PUT)
         */
        if(AdminRequest::action() == 'create'){
            $this->action = 'create';
            $this->method = 'post';
        }else{
            $this->action = 'edit';
            $this->method = 'put';
        }
        $this->module = AdminRequest::module();
        $this->recipe = Recipe::get(AdminRequest::recipe());

        //via resource route
        /*$route_name = $route->getName();
        $uri_parts = explode(".",$route_name);
        if(count($uri_parts) > 3){
            $this->module = $uri_parts[1];
            $this->recipe = Recipe::get($uri_parts[1]);
        }else{
            $this->module = $uri_parts[0];
            $this->recipe = Recipe::get($uri_parts[0]);
        }*/

        $this->config = new AdminConfig();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('form',$this->form($view->data));
    }

    /**
     * Generate the forms view data
     * @param $data
     * @return object
     */
    public function form($data){
        $formfields = [];
        $form['method'] = $this->method;
        $form['url'] = AdminRequest::formAction()->url;

        /**
         * Select the active languages
         */
        $active_languages = Session::get('language.active');

        /**
         * Add a hidden id field to the form
         */
        $props = [
            "name" => 'id',
            "value" => AdminRequest::formAction()->id,
        ];
        $Input = FormField::get('hidden',$props)->input();
        $formfields["id"]["field"] = $Input;

        /**
         * For module 'settings'
         */
        if($this->recipe->moduleName == 'settings'){
            $form['formfields'] = $this->getSettingsFields($data);
        }else{
            /**
             * Generate the form fields from the recipe
             */
            $fields = $this->recipe->fields;
            foreach($fields as $name => $field){
                if(isset($field['input'])&&!empty($field['input'])){

                    /**
                     * Filter out the role selection (module users only) if not developer or administrator
                     */
                    if($name == 'role_id' && Session::get('user.role_id') > 2)
                    {
                        continue;
                    }

                    /**
                     * Generate language fields if exist
                     */
                    if($field['input'] == 'language'){

                        /**
                         * If the input type is 'language', instantiate the related
                         * translation recipe, usually the base models recipe name with suffix '_lang'
                         */
                        $recipe_lang = Recipe::get(AdminRequest::recipe().'_lang');

                        /**
                         * Get the fields of the language recipe as instantiated above
                         */
                        $recipe_lang_fields = $recipe_lang->fields;

                         /**
                         * If action = 'edit' select the translations
                         */
                        if($this->action == 'edit'){
                            $class = (new \ReflectionClass($this->recipe));
                            $model = 'App\\Models\\'.$class->getShortName();
                            $translations = $model::find($data['id'])->language->toArray();
                            //set array keys to language id
                            $translation_arr = [];
                            foreach($translations as $translation){
                                $translation_arr[$translation['language_id']] = $translation;
                            }
                        }

                        /**
                         * generate the form field for the default translation and hidden fields for active languages
                         */
                        foreach($active_languages as $language){

                            /**
                             * Generate the hidden fields for all active languages
                             * The label $label is used to mark the hidden field as language field inside the template
                             * therefore it is not provided here
                             */
                            if(isset($translation_arr[$language['id']])){
                                $value = $translation_arr[$language['id']][$name];
                            }else{
                                $value = null;
                            }
                            $props = [
                                "name" => $name.'_'.$language['abbr'],
                                "value" => $value,
                                "class" => "language"
                            ];
                            $Input = FormField::get('hidden',$props)->input();
                            $formfields[$name.'_'.$language['abbr']]['field'] = $Input;

                            /**
                             * Generate the default language field
                             */
                            if($language['default']){
                                $lang = Session::get('language.default_id');
                                $lang_abbr = Session::get('language.default_abbr');
                                if(isset($translation_arr[$lang])){
                                    $value = $translation_arr[$lang][$name];
                                }else{
                                    $value = null;
                                }
                                $label = isset($recipe_lang_fields[$name]['label']) ? $recipe_lang_fields[$name]['label'] : null;
                                $props = [
                                    "name" => $name,
                                    "label" => $label,
                                    "value" => $value,
                                    "language" => true
                                ];
                                $Input = FormField::get($recipe_lang_fields[$name]['input'],$props)->input();
                                $formfields[$name]['field'] = $Input;
                            }
                            //TODO: Make possible to not use langauge fields in cms
                        }

                    }else{

                        /**
                         * Generate all other form fields
                         */
                        $label = isset($field['label']) ? $field['label'] : null;
                        $value = isset($data[$name]) ? $data[$name] : null;
                        $props = [
                            "name" => $name,
                            "label" => $label,
                            "value" => $value
                        ];
                        /**
                         * Add extra properties for image fields
                         */
                        if($field['input'] == 'images'){
                           $props['maxfiles'] = $this->config->get(str_singular($this->recipe->module).'_max_images');
                           $props['maxsize'] = $this->config->get('images_max_size');
                           $props['active_languages'] = $active_languages;
                        }

                        $Input = FormField::get($field['input'],$props)->input();
                        $formfields[$name]['field'] = $Input;
                    }

                }
            }
            $form['formfields'] = $formfields;
        }
        return (object)$form;
    }

    /**
     * Define fields for settings
     */
    private function getSettingsFields($data){
        /**
         * Generate the form field from the configuration
         */
        $props = [
            "name" => $data->name,
            "label" => $data->label,
            "value" => $data->value
        ];
        $Input = FormField::get($data->input_type,$props)->input();
        $formfields[$data->name]['field'] = $Input;
        /**
         * Generate the form field for the configurations value type
         */
        $props = [
            "name" => 'value_type',
            "value" => $data->value_type,
        ];
        $Input = FormField::get('hidden',$props)->input();
        $formfields['value_type']['field'] = $Input;
        /**
         * Generate the form field for the configurations field
         */
        $props = [
            "name" => 'name',
            "value" => $data->name,
        ];
        $Input = FormField::get('hidden',$props)->input();
        $formfields['name']['field'] = $Input;
        return $formfields;
    }
}