<?php namespace App\Admin\Form;


class Radio extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
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