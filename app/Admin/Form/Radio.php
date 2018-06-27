<?php namespace App\Admin\Form;


class Radio{

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
        return $this;
    }

    public function view()
    {
        return $this->properties['value'];
    }

    public function input()
    {
        //dd($this->properties);
        return view('form.radio',['field' => $this->properties])->render();
    }
} 