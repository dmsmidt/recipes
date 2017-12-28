<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Admin\Creators\Seeder;


class CreateSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeder:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a seeder file according to the recipe';

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
            $seeder = new Seeder();
            if($seeder->create($name)){
                $this->line('<info>Created the seeder '.$name.'.</info>');
            }else{
                $this->error('Seeder creation of '.$name.' failed.');
            }
        }
    }
}
