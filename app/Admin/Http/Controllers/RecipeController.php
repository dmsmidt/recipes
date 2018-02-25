<?php namespace App\Admin\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Recipe;
use App\Admin\Creators\Recipe as RecipeCreator;
use App\Admin\Creators\ServiceProvider as ServiceProviderCreator;
use App\Admin\Creators\RouteAdd;
use App\Admin\Http\Requests\RecipeRequest;
use Lang;
use ClassCreator;
use Schema;

class RecipeController  extends AdminController {

    public function __construct(){
        parent::__construct();
    }

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
        $data['display'] = 'index';
        $data['recipes'] = Recipe::all();
        return view('admin')
            ->with("javascripts", ["/cms/js/recipes.js"])
            ->with("css", ["/cms/css/recipes.css"])
            ->with("topbar_buttons",[
                [
                    "text" => Lang::get('recipes.Delete all backups'),
                    "icon" => "fa-trash-o",
                    "classes" => "btnDeleteBackups big_button",
                    "href" => ""
                ],
                [
                    "text" => Lang::get('recipes.Migrate schema\'s'),
                    "icon" => "fa-database",
                    "classes" => "btnMigrate big_button",
                    "href" => ""
                ]
            ])
            ->nest('center','recipes.recipes',compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create()
	{
        if(isset($recipe) && !empty($recipe)){
            $_recipe = $recipe;
        }else{
            $_recipe = Recipe::get('standard');
        }
        $data['display'] = 'create';
        $data['recipe'] = $_recipe;
        //add type options to fields
        foreach($data['recipe']->fields as $name => $field){
            if(isset($field['type'])){
                //getting type_options
                $_type = 'App\\Admin\\Types\\'.ucfirst($field['type']);
                $type = new $_type($name,$field);
                $type_options = $type->getOptions();
                $data['recipe']->fields[$name]['type_options'] = $type_options;
            }
        }
        return view('admin')
            ->with("javascripts", ["/cms/js/recipes.js"])
            ->with("css", ["/cms/css/recipes.css"])
            ->nest('center','recipes.recipes',compact('data'));
    }

    /**
     * @param RecipeRequest $request
     * @return $this
     */
    public function store(RecipeRequest $request)
	{
        $_recipe = Recipe::build($request->input());
        $creator = new RecipeCreator();
        if($creator->create($_recipe)){
            return redirect('admin/recipes');
        }else{
            return redirect()->back();
        }
	}

	/**
	 * Display the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

    /**
     * Show the form for editing the specified resource.
     * @param $recipe
     * @return $this
     */
    public function edit($recipe)
	{
	    $_recipe = Recipe::get($recipe);
        $data['display'] = 'edit';
        $data['recipe'] = $_recipe;
        //add type options to fields
        foreach($data['recipe']->fields as $name => $field){
            if(isset($field['type'])){
                //getting type_options
                $_type = 'App\\Admin\\Types\\'.studly_case($field['type']);
                $type = new $_type($name,$field);
                $type_options = $type->getOptions();
                $data['recipe']->fields[$name]['type_options'] = $type_options;
            }
        }
        return view('admin')
            ->with("javascripts", ["/cms/js/recipes.js"])
            ->with("css", ["/cms/css/recipes.css"])
            ->nest('center','recipes.recipes',compact('data'));
	}

    /**
     * @param RecipeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RecipeRequest $request)
	{
        $_recipe = Recipe::build($request->input());
        $creator = new RecipeCreator();
        if($creator->create($_recipe)){
            return redirect('admin/recipes');
        }else{
            return redirect()->back();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    /**
     * BELOW ALL AJAX REQUESTS METHODS
     */

    /**
     * add a new field row
     * @param $data
     * @param $callback
     * @return array
     */
    public function newFieldRow($data, $callback){
        return [
            'callback' => $callback,
            'args' => view('recipes.recipes_fieldrow',['row' => $data['num_fields'], 'name' => '', 'field' => ''])->render()
        ];
    }

    public function selectTypeOptions($data, $callback){
        $_type = 'App\\Admin\\Types\\'.ucfirst($data['type']);
        $type = new $_type($data['row'],[]);
        $type_options = $type->getOptions();
        return [
            'callback' => $callback,
            'args' => [
                        'html' => view('recipes.recipes_typeoptions',['row' => $data['row'], 'field' => ['type_options' => $type_options]])->render(),
                        'row' => $data['row']
                      ]
        ];
    }

    public function recipeExists($data, $callback){
        if(file_exists(app_path().'/Admin/Recipes/'.studly_case(str_singular($data['name'])).'.php' )){
            return [
                'callback' => $callback,
                'args' => [
                    'name' => $data['name'],
                    'exists' => true
                ]
            ];
        }else{
            return [
                'callback' => $callback,
                'args' => [
                    'name' => $data['name'],
                    'exists' => false
                ]
            ];
        }
    }

    public function tableExists($data, $callback){
        if(Schema::hasTable($data['table'])){
            return [
                'callback' => $callback,
                'args' => [
                    'exists' => true
                ]
            ];
        }else{
            return [
                'callback' => $callback,
                'args' => [
                    'exists' => false
                ]
            ];
        }
    }

    /**
     * copies all recipe classes to a backup folder inside the class's folder
     * @param $data
     * @param $callback
     * @return array
     */
    public function backupRecipe($data, $callback){
        $messages = [];
        $icon = 'icon-true';
        $page_refresh = false;
        //BACKUP Recipe
        $recipe = studly_case(str_singular($data['recipe']));
        $app_path = app_path();
        if(file_exists($app_path.'/Admin/Recipes/'.$recipe.'.php')){
            $file = $app_path.'/Admin/Recipes/'.$recipe.'.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Admin/Recipes/backups/'.$recipe.'_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ["type" => "succes", "text" => "The recipe backup file ".$recipe."_".$datetime.".php has been made."];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Could not make a backup file of recipe '.$recipe.'.'];
                $icon = 'icon-alert';
            }
        }
        //BACKUP Model
        if(file_exists($app_path.'/Models/'.$recipe.'.php')){
            $file = $app_path.'/Models/'.$recipe.'.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Models/backups/'.$recipe.'_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ['type' => 'succes', 'text' => 'The model backup file '.$recipe.'_'.$datetime.'.php has been made.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Could not make a backup file of model '.$recipe.'.'];
                $icon = 'icon-alert';
            }
        }
        //BACKUP Controller
        if(file_exists($app_path.'/Admin/Http/Controllers/'.$recipe.'Controller.php')){
            $file = $app_path.'/Admin/Http/Controllers/'.$recipe.'Controller.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Admin/Http/Controllers/backups/'.$recipe.'Controller_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ['type' => 'succes', 'text' => 'The controller backup file '.$recipe.'Controller_'.$datetime.'.php has been made.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Could not make a backup file of '.$recipe.'Controller.'];
                $icon = 'icon-alert';
            }
        }
        //BACKUP Requests
        if(file_exists($app_path.'/Admin/Http/Requests/'.$recipe.'Request.php')){
            $file = $app_path.'/Admin/Http/Requests/'.$recipe.'Request.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Admin/Http/Requests/backups/'.$recipe.'Request_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ['type' => 'succes', 'text' => 'The Backup file '.$recipe.'Request_'.$datetime.'.php has been made.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' =>'Could not make a backup file of '.$recipe.'Request.'];
                $icon = 'icon-alert';
            }
        }
        //BACKUP Repository
        if(file_exists($app_path.'/Admin/Repositories/'.$recipe.'Repository.php')){
            $file = $app_path.'/Admin/Repositories/'.$recipe.'Repository.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Admin/Repositories/backups/'.$recipe.'Repository_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ['type' => 'succes', 'text' => 'The Repository backup file '.$recipe.'Repository_'.$datetime.'.php has been made.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Could not make a backup file of '.$recipe.'Repository.'];
                $icon = 'icon-alert';
            }
        }
        //BACKUP Repository contract
        if(file_exists($app_path.'/Admin/Repositories/Contracts/I'.$recipe.'Repository.php')){
            $file = $app_path.'/Admin/Repositories/Contracts/I'.$recipe.'Repository.php';
            $datetime = date('dmY_His');
            $backup = $app_path.'/Admin/Repositories/Contracts/backups/I'.$recipe.'Repository_'.$datetime.'.php';
            if(copy($file,$backup)){
                $messages[] = ['type' => 'succes', 'text' => 'The Backup file '.$recipe.'Repository_'.$datetime.'.php has been made.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Could not make a backup file of I'.$recipe.'Repository.'];
                $icon = 'icon-alert';
            }
        }
        if(count($messages)){
            $data['module'] = 'recipes';
            $data['dialog'] = 'attention';
            $data['messages'] = $messages;
            $data['icon'] = isset($icon) ? $icon : null;
            $data['page_refresh'] = isset($page_refresh) ? $page_refresh : false;
            return [
                'callback' => 'openDialog',
                'args' => view('dialogs.dialog',["data" => $data])->render()
            ];
        }else{
            return [
                'callback' => $callback,
                'args' => []
            ];
        }
    }

    /**
     * Empties all recipe classes backup folders
     * @param null $data
     * @param null $callback
     * @return array
     */
    public function deleteAllBackups($data = null, $callback = null){
        $backup_paths = [
            app_path().'/Admin/Http/Controllers/backups',
            app_path().'/Admin/Http/Requests/backups',
            app_path().'/Admin/Repositories/backups',
            app_path().'/Admin/Repositories/Contracts/backups',
            app_path().'/Models/backups',
        ];
        $file_cnt = 0;
        $file_succes = 0;
        foreach($backup_paths as $path){
            $files = glob($path.'/*');
            foreach($files as $file) {
                $file_cnt++;
                if (is_file($file)){
                    if (unlink($file)) {
                        $file_succes++;
                    }
                }
            }
        }
        if($file_cnt){
            $messages[] = ['type' => 'succes', 'text' => $file_succes.' of '.$file_cnt.' were deleted.'];
            return $this->messageDialog($messages, $callback);
        }
    }

    /**
     * Migrates all schema's
     * @param null $data
     * @param null $callback
     * @return array
     */
    public function migrateSchemas($data = null, $callback = null){
        Artisan::call('migrate');
        $messages[] = ['type' => 'succes', 'text' => 'The migration is done.'];
        return $this->messageDialog($messages, $callback);
    }

    public function deleteClasses($data = null, $callback = null){
        $recipe = $data['recipe'];
        $class_name = studly_case(str_singular($recipe));
        $paths = [
            app_path().'/Admin/Http/Controllers/'.$class_name.'Controller.php',
            app_path().'/Admin/Http/Requests/'.$class_name.'Request.php',
            app_path().'/Admin/Repositories/'.$class_name.'Repository.php',
            app_path().'/Admin/Repositories/Contracts/I'.$class_name.'Repository.php',
            app_path().'/Admin/Providers/'.$class_name.'ServiceProvider.php',
            app_path().'/Models/'.$class_name.'.php',
        ];
        $names = [
            "Controller class",
            "Request class",
            "Repository",
            "Repository Interface",
            "Provider class",
            "Model class"
        ];
        $messages = [];
        //remove class files
        foreach($paths as $key => $path){
            if(file_exists($path)){
                if(unlink($path)){
                    $messages[] = ['type' => 'succes', 'text' => 'The '.$names[$key].' has been deleted.'];
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The '.$names[$key].' has not been deleted.'];
                }
            }
        }
        //remove route and provider
        $provider = new ServiceProviderCreator;
        if($provider->remove($recipe)){
            $messages[] = ['type' => 'succes', 'text' => 'The '.$names[$key].' service provider has been removed.'];
        }else{
            $messages[] = ['type' => 'alert', 'text' => 'The '.$names[$key].' service provider could not be removed.'];
        }
        $route = new RouteAdd;
        if($route->remove($recipe)){
            $messages[] = ['type' => 'succes', 'text' => 'The '.$names[$key].' route has been removed.'];
        }else{
            $messages[] = ['type' => 'alert', 'text' => 'The '.$names[$key].' route could not be removed.'];
        }

        return $this->messageDialog($messages, $callback);
    }

    /**
     * creates the model class
     * @param $data
     * @param $callback
     * @return array
     */
    public function createModel($data, $callback){
        $messages = ClassCreator::create('model',$data['recipe']);
        return $this->messageDialog($messages, $callback);
    }

    /**
     * creates the controller class
     * @param $data
     * @param $callback
     * @return array
     */
    public function createController($data, $callback){
        $messages = ClassCreator::create('controller',$data['recipe']);
        return $this->messageDialog($messages, $callback);
    }

    /**
     * creates the repository class
     * @param $data
     * @param $callback
     * @return array
     */
    public function createRepository($data, $callback){
        $messages = ClassCreator::create('repository',$data['recipe']);
        return $this->messageDialog($messages, $callback);
    }

    /**
     * creates the language resource files
     * @param $data
     * @param $callback
     * @return array
     */
    public function createTranslations($data, $callback){
        $messages = ClassCreator::create('translations',$data['recipe']);
        return $this->messageDialog($messages, $callback);
    }

    /**
     * returns the message html to ajax to display in the dialog
     * @param $messages
     * @param $callback
     * @return array
     */
    protected function messageDialog($messages, $callback){
        if(count($messages)){
            $data['module'] = 'recipes';
            $data['dialog'] = 'attention';
            $data['messages'] = $messages;
            $data['icon'] = 'fa fa-exclamation-triangle';
            $data['page_refresh'] = $callback == 'refreshWindow' ? true : false;
            return [
                'callback' => 'openDialog',
                'args' => view('dialogs.dialog',["data" => $data])->render()
            ];
        }else{
            return [
                'callback' => $callback,
                'args' => []
            ];
        }
    }


}
