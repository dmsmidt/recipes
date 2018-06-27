<?php namespace App\Admin\Form;


class Nestable {

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
        return $this;
    }

    public function view()
    {
        return '
        <a href="/admin/'.$this->module.'/'.$this->properties['value'].'/'.$this->properties['name'].'">
        <button type="button" class="row_btn"><i class="fas fa-bars"></i><span></span>
        </button>
        </a>';
    }

    public function input()
    {
        //
    }
}
