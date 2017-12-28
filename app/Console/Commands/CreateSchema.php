<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Migration;

class CreateSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schema:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a table migration schema according to the recipe.';

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
        $recipe = 'App/Admin/Recipes/'.$name.'.php';
        if(!file_exists($recipe)){
            $this->error('The recipe '.$name.' does not exists.');
        }else{
            $schema = new Migration();
            if($schema->create($name)){
                $this->line('<info>Created the schema '.$name.'.</info>');
                //$this->call('migrate');
            }else{
                $this->error('Schema creation of '.$name.' failed.');
            }
        }
    }
}
