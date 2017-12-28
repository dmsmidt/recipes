<?php namespace App\Admin\Form;


class Nestable extends FormField {

    public function __construct($props = null){
        $this->build($props);
        return $this;
    }

    public function view()
    {
        return '
        <a href="/admin/'.$this->module.'/'.$this->properties['value'].'/'.$this->properties['name'].'">
        <button type="button" class="row_btn"><i class="fa fa-bars"></i><span></span>
        </button>
        </a>';
    }

    public function input()
    {
        //
    }
}
