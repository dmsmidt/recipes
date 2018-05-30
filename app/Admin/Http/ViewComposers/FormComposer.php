<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Route;
use App\Admin\Http\Requests\AdminRequest;
use Recipe;
use FormField;
use Session;


class FormComposer {

    protected $admin_request;
    protected $recipe;
    protected $action; //the basic action (create or edit)
    protected $method; //the form method (POST or PUT)
    protected $url; //the action url of the form
    protected $id; //If model editing, the id is id of the model

    public function __construct(Route $route, AdminRequest $adminRequest){

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
                    $props = FormField::getProperties($field, $name, $data);

                    //echo '<pre>'.print_r($props,true).'</pre>';
                    $formfields[$name]['field'] = FormField::get($props)->input();

                }
            }
            //die();
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