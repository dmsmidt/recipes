<?php namespace App\Admin\Http\Requests;

use Request;
use Route;

class AdminRequest extends Request {


    /**
     * Extract recipe from url path
     * @return string
     */
    public function recipe(){
       $request_arr = Request::segments();
       if(count($request_arr)>3){
            if($request_arr[3] != 'edit'){
                return $request_arr[3];
            }else{
                return $request_arr[1];
            }
       }else{
           return $request_arr[1];
       }
    }

    /**
     * Extract the module from url path
     * @return string
     */
    public function module(){
        return $this->segments()[1];
    }

    /**
     * Get the route action name
     * @return string
     */
    public function action(){
        $action_arr = Route::currentRouteAction();
        return substr($action_arr,strrpos($action_arr,'@')+1);
    }

    /**
     * Get the current route name (dot notation)
     * @return string
     */
    public function route(){
        return Route::currentRouteName();
    }

    /**
     * Return an array with uri segments
     * @return array
     */
    public function segments(){
        return Request::segments();
    }

    /**
     * Return a string with uri path
     * @return string
     */
    public function path(){
        return Request::path();
    }

    /**
     * Returns true if the module has editable related child models
     * @return bool
     */
    public function hasChilds(){
        $request_arr = Request::segments();
        if(count($request_arr)>3){
            if($request_arr[3] != 'edit'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function parent_id(){
        $request_arr = Request::segments();
        return $request_arr[2];
    }

    public function formAction(){
        $segments = $this->segments();
        $form_action = [];
        if(count($segments) > 4){
            $form_action['url'] = '';
            $form_action['id'] = $segments[4];
            for($n = 0; $n<count($segments)-1; $n++){
                $form_action['url'] .= '/'.$segments[$n];
            }
        }else{
            //the form action url must be a resource route
            $form_action['url'] = "/admin/".$this->module();
            switch($this->action()){
                case"edit":
                $form_action['url'] .= '/'.$segments[2];
                $form_action['id'] = $segments[2];
                break;
                case"create":
                    $form_action['id'] = '';
                break;
            }
        }
        return (object)$form_action;
    }

    /**
     * Returns the moduleName of the parent module if exists otherwise returns null
     * @return mixed
     */
    public function parentModule(){
        if($this->hasChilds()){
            $segments = $this->segments();
            $filter_arr = ['admin','edit','create'];
            $modules = [];
            foreach($segments as $segment){
                if(!in_array($segment,$filter_arr) && !is_numeric($segment)){
                    $modules[] = $segment;
                }else{
                    continue;
                }
            }
            return $modules[0];
        }
        return null;
    }

    /**
     * Returns the moduleName of the child module otherwise returns null
     * @return mixed
     */
    public function childModule(){
        if($this->hasChilds()){
            $segments = $this->segments();
            $filter_arr = ['admin','edit','create','ajax'];
            $modules = [];
            foreach($segments as $segment){
                if(!in_array($segment,$filter_arr) && !is_numeric($segment)){
                    $modules[] = $segment;
                }else{
                    continue;
                }
            }
            return last($modules);
        }
        return null;
    }

    public function moduleItemId(){
        $segments = $this->segments();
        return $segments[2];
    }


}
