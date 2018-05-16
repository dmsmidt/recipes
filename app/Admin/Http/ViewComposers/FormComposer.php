<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Route;
use App\Admin\Http\Requests\IAdminRequest;
use Recipe;
use FormField;
use Session;
use App\Admin\Services\AdminConfig;


class FormComposer {

    protected $admin_request;
    protected $recipe;
    protected $action; //the basic action (create or edit)
    protected $method; //the form method (POST or PUT)
    protected $url; //the action url of the form
    protected $id; //If model editing, the id is id of the model
    protected $config;

    public function __construct(Route $route, IAdminRequest $adminRequest){

        /**
         * Define the controller action (edit or create) and request method (POST or PUT)
         */
        $this->admin_request = $adminRequest;
        if($adminRequest->action() == 'create'){
            $this->action = 'create';
            $this->method = 'post';
        }else{
            $this->action = 'edit';
            $this->method = 'put';
        }
        $this->recipe = Recipe::get($adminRequest->recipe());
        $form_action = $adminRequest->formAction();
        $this->url = $form_action->url;
        $this->id = $form_action->id;
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

        //dd($data);

        $formfields = [];

        /**
         * Define the forms method and action url
         */
        $form['method'] = $this->method;
        $form['url'] = $this->url;

        /**
         * Select the active languages
         */
        $active_languages = Session::get('language.active');

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
            //dd($fields);
            foreach($fields as $name => $field){
                /*if($name == 'text'){
                    dd($data[$name]);
                }*/

                if(isset($field['input']) && !empty($field['input'])){

                    /**
                     * Filter out the role selection (module users only) if not developer or administrator
                     */
                    if($name == 'role_id' && Session::get('user.role_id') > 2)
                    {
                        continue;
                    }

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
                    if($field['input'] == 'images' || $field['input'] == 'image'){
                       //$props['maxfiles'] = $this->config->get(str_singular($this->recipe->moduleName).'_max_images');
                       $props['maxsize'] = $this->config->get('max_image_size');
                       $props['active_languages'] = $active_languages;
                       $props['image_template'] = 1;
                    }

                    /**
                     * Generate hidden id_fields for relationships
                     * These fields contain a hidden input and _id in the name
                     */
                    if($field['input'] == 'hidden' && strpos($name,'_id') !== false && count($this->admin_request->segments()) >= 5){
                        $props['value'] = $this->admin_request->parent_id();
                    }
                    $formfields[$name]['field'] = FormField::get($field['input'], $props)->input();

                }
            }
            $form['formfields'] = $formfields;
        }
        return (object)$form;
    }

    /**
     * Define fields for the settings in configuration
     *
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