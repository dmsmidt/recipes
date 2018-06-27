<?php namespace App\Admin\Form;

class Email{

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
        return view('form.email',['field' => $this->properties])
            ->render();
    }

} 