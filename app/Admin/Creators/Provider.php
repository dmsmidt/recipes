<?php namespace App\Admin\Creators;


class Provider {

    /**
     * creates the repository and interface
     * @param $name
     * @return bool
     */
    public function create($name){
        $provider = studly_case(str_singular($name));
        $path = app_path().'/Admin/Providers/'.$provider.'ServiceProvider.php';
        $file = fopen($path,'w+');
        $extends = 'ServiceProvider';
        $use = 'use Illuminate\Support\ServiceProvider;';
        $str = <<<START
<?php namespace App\Admin\Providers;

{$use}

class {$provider}ServiceProvider extends ServiceProvider{

    /**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        \$this->app->bind(
            'App\Admin\Repositories\Contracts\I{$provider}Repository','App\Admin\Repositories\\{$provider}Repository');
	}

START;

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }
}