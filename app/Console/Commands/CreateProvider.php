<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Provider;

class CreateProvider extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'provider:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a repository service provider';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $file = 'app/Admin/Providers/'.studly_case(str_singular($name)).'ServiceProvider.php';
        if(!file_exists($file)){
            $provider = new Provider();
            if($provider->create($name)){
                $this->info('<info>Created the ServiceProvider '.studly_case(str_singular($name)).'.'.PHP_EOL.'You have to manually add the provider to the provider array in config/app.php</info>');

            }else{
                $this->error('ServiceProvider creation of '.studly_case(str_singular($name)).' failed.');
            }
        }else{
            $this->error('The ServiceProvider '.studly_case(str_singular($name)).' already exists.');
        }
    }

}
