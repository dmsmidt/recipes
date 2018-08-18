<?php namespace App\Admin\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use Request;
use View;
use App\Models\Language;
use App;
use AdminRequest;

class AdminController extends Controller
{

    protected $lang;

    public function __construct(){
        View::share('moduleName',Request::segment(2));
    }

    /**
     * Ajax.
     * @param $module
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax($module){
        if(Request::ajax())
        {
            $data = Request::all();
            $data['params']['urlModule'] = $module;
            //if string module contains slashes remove the part from de first slash to keep only the module name
            if(strpos($module,'/') !== false){
                $data['params']['urlModule'] = substr($module,0,strpos($module,'/'));
            }
            if(!isset($data['method']) || $data['method'] == ''){
                return \Response::json(['error'=>'No method defined @ajax request']);
            }
            $method = $data['method'];
            $params = $data['params'];
            if(isset($data['callback'])){
                $callback = $data['callback'];
                return \Response::json($this->$method($params,$callback));
            }
            return \Response::json($this->$method($params));
        }
    }

    /**
     * Ajax call.
     * switching the languages via ajax call
     * @param $data
     * @param $callback
     * @return array
     */
    public function switchLanguage($data, $callback){
        $language = Language::where('abbr',$data['lang'])->get()->first();
        Session::put('language.default_id',$language->id);
        Session::put('language.default_abbr',$language->abbr);
        return [
            "callback" => $callback,
            "args" => $data['lang']
        ];
    }

    /**
     * Ajax call.
     * update a sortable or nestable set
     * @param $data
     * @param $callback
     * @return array
     * @throws \Exception
     */
    public function nestableUpdate($data, $callback){
        $child_module = AdminRequest::childModule();
        if($child_module){
            $module = 'App\\Models\\'.str_singular(studly_case($child_module));
        }else{
            $module = 'App\\Models\\'.str_singular(studly_case(AdminRequest::module()));
        }
        unset($data['urlModule']);
        $node = $module::find($data['id']);
        if(isset($data['prev_id']) && !empty($data['prev_id'])){
            $left_node = $module::find($data['prev_id']);
            $node->moveToRightOf($left_node);
        }elseif(isset($data['parent_id']) && !empty($data['parent_id']) ){
            $parent_node = $module::find($data['parent_id']);
            $first_sibling = $node->siblingsAndSelf()->first();
            if($node->id !== $first_sibling->id){
                $node->makeFirstChildOf($parent_node);
            }
        }else{
            $first_sibling = $node->siblingsAndSelf()->first();
            if($node->id !== $first_sibling->id && !isset($node->parent_id)){
                $node->moveToLeftOf($first_sibling);
            }else{
                $node->makeRoot();
                $first_sibling = $node->siblingsAndSelf()->first();
                try{
                    $node->moveToLeftOf($first_sibling);
                }catch(\Exception $e){
                    if($e instanceof \Baum\MoveNotPossibleException){
                        //
                    }else{
                        throw $e;
                    }
                }
            }
        }
        //$module::rebuild(true);
        return [
            "callback" => $callback,
            "args" => ''
        ];
    }

    /**
     * Ajax call.
     * @param $data
     * @param $callback
     * @return array
     */
    public function dialog($data ,$callback){
        return [
            "callback" => $callback,
            "args" => view('dialogs.dialog',["data" => $data])->render()
        ];
    }

    /**
     * Ajax call
     * @param $data
     * @param $callback
     * @return array
     */
    public function toggleActivate($data,$callback){
        $Model = 'App\\Models\\'.str_singular(studly_case($data['module']));
        $model = $Model::find($data['id']);
        $model->active = $model->active == 1 ? 0 : 1;
        $model->save();
        return [
            "callback" => $callback,
            "args" => ''
        ];
    }

    /**
     * Ajax call
     * @param $data
     * @param $callback
     * @return array
     */
    public function toggleProtect($data,$callback){
        $Model = 'App\\Models\\'.str_singular(studly_case($data['module']));
        $model = $Model::find($data['id']);
        $model->protect = $model->protect == 1 ? 0 : 1;
        $model->save();
        return [
            "callback" => $callback,
            "args" => ''
        ];
    }

    public function crop($data, $callback){
        return [
            "callback" => $callback,
            "args" => view('main.crop',["data" => $data])->render()
        ];
    }
}
