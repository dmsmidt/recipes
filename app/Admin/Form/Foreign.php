<?php namespace App\Admin\Form;


class Foreign{

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
        return $this;
    }

    public function view()
    {
        return '
        <a href="/admin/'.$this->properties['moduleName'].'/'.$this->properties['value'].'/'.$this->properties['name'].'">
        <button type="button" class="row_btn"><div class="fas fa-bars"></div><span></span>
        </button>
        </a>';
    }

    public function input()
    {
        //
    }
}
