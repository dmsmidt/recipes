<?php namespace App\Admin\Form;

class Email extends FormField{

    public function __construct($props = null){
        $this->build($props);
        return $this;
    }

    public function view()
    {
        return $this->properties['value'];
    }

    public function input()
    {
        return view('form.email',['field' => $this->properties])
            ->render();
    }

} 