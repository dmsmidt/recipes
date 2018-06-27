<?php namespace App\Admin\Form;


class Password{

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
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