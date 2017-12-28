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
            $messages[] = ['type' => 'alert', 'text' => 'The model '.$this->recipe.' already exists.'];
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
                }else{
                    $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Request could not be created.'];
                }
            }else{
                $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Controller could not be created.'];
            }
        }else{
            $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Controller already exists.'];
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
                        $messages[] = ['type' => 'info', 'text' => 'Add the path to the providers array in config/app.php manually.'];
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
            $messages[] = ['type' => 'alert', 'text' => 'The '.$this->recipe.'Repository already exists.'];
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