<?php namespace App\Admin\Form;


class MultiGroupedCheckbox extends FormField{

    public function __construct($props = null){
        $this->build($props);
        return $this;
    }

    public function view()
    {
        if($this->properties['value'])
        {
            return '<div class="fa fa-check-square-o"></div>';
        }
        return '<div class="fa fa-square-o"></div>';
    }

    public function input()
    {
        return view('form.multiGroupedCheckbox',['field' => $this->properties])
            ->render();
    }
} 