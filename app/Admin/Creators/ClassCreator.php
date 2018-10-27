<?php namespace App\Admin\Creators;
/**
 * All classes inside this namespace can be called by the console (see php artisan list), or
 * by this class to automatically generate all the necessary core classes from a recipe.
 */

class ClassCreator {

    protected $recipe;
    protected $name;

    public function create($class, $name){
        $this->recipe = studly_case(str_singular($name));
        $this->name = $name;
        return $this->$class();
    }

    protected function model(){
        $file = app_path().'/Models/'.$this->recipe.'.php';
        $messages = [];
        if(!file_exists($file)){
            $_model = new Model();
            if($_model->create($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'Created the model '.$this->recipe.'.'];
                $_migration = new Migration();
                if($_migration->create($this->recipe)){
                    $messages[] = ['type' => 'succes', 'text' => 'Created the migration for '.$this->recipe.'.'];
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The migration for '.$this->recipe.' could not be created.'];
                }
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'Model creation of '.$this->recipe.' failed.'];
            }
        }else{
            $_model = new Model();
            if($_model->remove($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'Removed the model '.$this->recipe.'.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The Model for '.$this->recipe.' could not be removed.'];
            }
        }
        return $messages;
    }

    protected function controller(){
        $file = app_path().'/Admin/Http/Controllers/'.$this->recipe.'Controller.php';
        $messages = [];
        if(!file_exists($file)){
            $_controller = new Controller();
            if($_controller->create($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'Created the '.$this->recipe.'Controller.'];
                $_request = new Request();
                if($_request->create($this->recipe)){
                    $messages[] = ['type' => 'succes', 'text' => 'Created the '.$this->recipe.'Request.'];
                    $route_add = new RouteAdd();
                    if($route_add->create($this->name)){
                        $messages[] = ['type' => 'succes', 'text' => 'Added the resource route.'];
                    }else{
                        $messages[] = ['type' => 'alert', 'text' => 'Could not add the resource route.'];
                    }
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Request could not be created.'];
                }
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Controller could not be created.'];
            }
        }else{
            $_controller = new Controller();
            if($_controller->remove($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.'Controller has been removed.'];
                $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.'Request has been removed.'];
                $route_add = new RouteAdd();
                if($route_add->remove($this->name)){
                    $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.' resource route has been removed.'];
                }
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Controller could not be removed.'];
            }

        }
        return $messages;
    }

    protected function repository(){
        $file = app_path().'/Admin/Repositories/'.$this->recipe.'Repository.php';
        $messages = [];
        if(!file_exists($file)){
            $_repository = new Repository();
            if($_repository->create($this->name)){
                $messages[] = ['type' => 'succes', 'text' => 'Created the '.$this->recipe.'Repository.'];
                $_irepository = new IRepository();
                if($_irepository->create($this->name)){
                    $messages[] = ['type' => 'succes', 'text' => 'Created the I'.$this->recipe.'Repository.'];
                    $_provider = new Provider();
                    if($_provider->create($this->name)){
                        $messages[] = ['type' => 'succes', 'text' => 'Created the '.$this->recipe.'ServiceProvider.'];
                        $_service_provider = new ServiceProvider();
                        if($_service_provider->create($this->name)){
                            $messages[] = ['type' => 'succes', 'text' => 'The service provider has been added to config/app.php.'];
                        }else{
                            $messages[] = ['type' => 'alert', 'text' => 'The service provider could not be added to config/app.php'];
                        }
                    }else{
                        $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'ServiceProvider could not be created.'];
                    }
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The I'.$this->recipe.'Repository could not be created.'];
                }
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Repository could not be created.'];
            }
        }else{
            $_repository = new Repository();
            $_irepository = new IRepository();
            $_provider = new Provider();
            $_service_provider = new ServiceProvider();
            if($_repository->remove($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.'Repository has been removed.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Repository could not be removed.'];
            }
            if($_irepository->remove($this->recipe)){
                $messages[] = ['type' => 'succes', 'text' => 'The I'.$this->recipe.'Repository has been removed.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The I'.$this->recipe.'Repository could not be removed.'];
            }
            if($_provider->remove($this->name)){
                $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.'ServiceProvider has been removed.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'ServiceProvider could not be removed.'];
            }
            if($_service_provider->remove($this->name)){
                $messages[] = ['type' => 'succes', 'text' => 'The '.$this->recipe.'ServiceProvider has been removed from config/app.php.'];
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'ServiceProvider could not be removed from config/app.php.'];
            }
        }
        return $messages;
    }

    protected function translations(){
        $languages = array_diff(scandir(base_path().'/resources/lang'), array('..', '.'));
        $messages = [];
        foreach($languages as $language){
            $file = base_path().'/resources/lang/'.$language.'/'.$this->name.'.php';
            if(!file_exists($file)){
                $_translations = new Translations();
                if($_translations->create($language, $this->name)){
                    $messages[] = ['type' => 'succes', 'text' => 'Created the '.$this->name.' '.$language.' translation file.'];
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The '.$this->name.' translation files could not be created.'];
                }
            }
        }
        return $messages;
    }
}