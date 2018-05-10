<?php namespace App\Admin\Form;

class Hidden extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
        return $this;
    }

    public function view()
    {
        //
    }

    public function input()
    {
        return view('form.hidden',['field' => $this->properties])
            ->render();
    }

} 