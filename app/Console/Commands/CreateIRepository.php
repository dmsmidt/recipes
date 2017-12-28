<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\IRepository;

class CreateIRepository extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'irepository:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a repository interface';

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
        $file = 'app/Admin/Repositories/Contracts/I'.studly_case(str_singular($name)).'Repository.php';
        if(!file_exists($file)){
            $_repository = new IRepository();
            if($_repository->create($name)){
                $this->line('<info>Created the IRepository '.studly_case(str_singular($name)).'.</info>');
                $this->call('provider:create', ["name" => $name]);
            }else{
                $this->error('IRepository creation of '.studly_case(str_singular($name)).' failed.');
            }
        }else{
            $this->error('The IRepository '.studly_case(str_singular($name)).' already exists.');
        }
    }

}
