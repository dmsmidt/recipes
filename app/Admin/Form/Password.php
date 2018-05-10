<?php namespace App\Admin\Form;


class Password extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
    }

    public function view()
    {
        //
    }

    public function input()
    {
        return view('form.password',['field' => $this->properties])
            ->render();
    }

} 