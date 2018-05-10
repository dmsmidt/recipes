<?php namespace App\Admin\Form;


class Checkbox extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
    }

    public function view()
    {
        if($this->properties['value'])
        {
            return '<div class="icon-checkbox2"></div>';
        }
        return '<div class="icon-checkbox3"></div>';
    }

    public function input()
    {
        return view('form.checkbox',['field' => $this->properties])
            ->render();
    }
} 