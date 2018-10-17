<?php namespace App\Admin\Services;

use App\Admin\Repositories\ConfigurationRepository;

class AdminConfig {

    protected $settings;

    public function __construct(){
        $repository = new ConfigurationRepository();
        $this->settings = $repository->selectSettings();
    }

    public function all(){
        return $this->settings;
    }

    public function get($name){
        //dd($this->settings);
        $type = $this->settings[$name]->value_type;
        $value = $this->settings[$name]->$type;
        return $value;
    }



} 