<?php namespace App\Admin\Form;

class Text extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
        return $this;
    }

    public function view()
    {
        return $this->properties['value'];
    }

    public function input()
    {
        return view('form.text',['field' => $this->properties])
            ->render();
    }

}