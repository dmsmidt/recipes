<?php namespace App\Admin\Form;


class Password extends FormField{

    public function __construct($props = null){
        $this->build($props);
        return $this;
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