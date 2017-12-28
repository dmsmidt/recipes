<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Repository;

class CreateRepository extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'repository:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a repository class';

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

            $file = 'app/Admin/Repositories/'.studly_case(str_singular($name)).'Repository.php';
            if(!file_exists($file)){
                $_repository = new Repository();
                if($_repository->create($name)){
                    $this->line('<info>Created the repository '.studly_case(str_singular($name)).'.</info>');
                    $this->call('irepository:create', ["name" => $name]);
                }else{
                    $this->error('Repository creation of '.studly_case(str_singular($name)).' failed.');
                }
            }else{
                $this->error('The repository '.studly_case(str_singular($name)).' already exists.');
            }
    }

}
