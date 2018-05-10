<?php namespace App\Admin\Form;


class MultiGroupedCheckbox extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
    }

    public function view()
    {
        if($this->properties['value'])
        {
            return '<div class="far fa-check-square"></div>';
        }
        return '<div class="far fa-square"></div>';
    }

    public function input()
    {
        return view('form.multiGroupedCheckbox',['field' => $this->properties])
            ->render();
    }
} 