<?php namespace App\Admin\Form;


class Select extends FormField{

    public function __construct($props){
        $this->properties = $props;
        return $this;
    }

    public function view()
    {
        return $this->properties['options'][$this->properties['value']];
    }

    public function input()
    {
        return view('form.select',['field' => $this->properties])
            ->render();
    }
} 