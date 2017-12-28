<?php namespace App\Admin\Form;


class Foreign extends FormField {

    public function __construct($props = null){
        $this->build($props);
        return $this;
    }

    public function view()
    {
        return '
        <a href="/admin/'.$this->module.'/'.$this->properties['value'].'/'.$this->properties['name'].'">
        <button type="button" class="row_btn"><div class="fa fa-external-link-square"></div><span></span>
        </button>
        </a>';
    }

    public function input()
    {
        //
    }
}
