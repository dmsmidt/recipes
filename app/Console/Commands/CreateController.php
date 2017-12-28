<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Controller;

class CreateController extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'controller:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a controller class';

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

            $file = 'app/Admin/Http/Controllers'.studly_case(str_singular($name)).'Controller.php';
            if(!file_exists($file)){
                $_controller = new Controller();
                if($_controller->create($name)){
                    $this->line('<info>Created the controller '.studly_case(str_singular($name)).'.</info>');
                }else{
                    $this->error('Controller creation of '.studly_case(str_singular($name)).' failed.');
                }
            }else{
                $this->error('The controller '.studly_case(str_singular($name)).' already exists.');
            }
    }

}
