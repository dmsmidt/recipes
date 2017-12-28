<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Lang;


class DialogComposer {

    protected $moduleName;
    protected $urlModule;
    protected $id;
    protected $dialog;
    protected $url;

    public function __construct(Route $route){

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->data;
        $this->moduleName = isset($data['module']) ? $data['module'] : null;
        $this->urlModule = isset($data['urlModule']) ? $data['urlModule'] : null;
        $this->id = isset($data['id']) && !empty($data['id']) ? $data['id'] : null;
        $this->dialog = $data['dialog'];
        $this->url = isset($data['url']) ? $data['url'] : null;
        $add_data = $this->{$data['dialog']}($data);
        if(is_array($add_data)){
            $data = array_merge($data,$add_data);
        }
        $view->nest('content','dialogs.'.$data['dialog'],compact('data'));
    }

    /**
     * Compose view data for delete dialog
     * @return mixed
     */
    public function delete()
    {
        $model = '\\App\\Models\\'.ucfirst(str_singular(studly_case($this->moduleName)));
        $record = $model::find($this->id);
        $data['name'] = $record->name;
        return $data;
    }

    /**
     * Compose view data for image delete dialog
     */
    public function image_delete($data){
        return $data;
    }

    /**
     * Compose view data for attention dialog
     */
    public function attention(){

    }


}