<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Request;

class CreateRequest extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'request:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a form request class';

    /**
     * Create a new command instance.
     *
     */
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

            $file = 'app/Admin/Http/Requests'.studly_case(str_singular($name)).'Request.php';
            if(!file_exists($file)){
                $_request = new Request();
                if($_request->create($name)){
                    $this->line('<info>Created the request '.studly_case(str_singular($name)).'.</info>');
                }else{
                    $this->error('Request creation of '.studly_case(str_singular($name)).' failed.');
                }
            }else{
                $this->error('The request '.studly_case(str_singular($name)).' already exists.');
            }
    }

}
