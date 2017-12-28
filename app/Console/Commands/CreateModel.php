<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Model;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a model class from a corresponding recipe';

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
        if(!file_exists('App/Admin/Recipes/'.$name.'.php')){
            $this->error('The recipe '.$name.' does not exists.');
        }else{
            $file = 'App/Models/'.$name.'.php';
            if(!file_exists($file)){
                $_model = new Model();
                if($_model->create($name)){
                    $this->line('<info>Created the model '.studly_case($name).'.</info>');
                    //$this->call('schema:create', ["name" => $name]);
                }else{
                    $this->error('Model creation of '.studly_case($name).' failed.');
                }
            }else{
                $this->error('The model '.studly_case($name).' already exists.');
            }
        }
    }
}
