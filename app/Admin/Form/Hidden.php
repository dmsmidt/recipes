<?php namespace App\Admin\Form;

class Hidden{

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
        return view('form.hidden',['field' => $this->properties])
            ->render();
    }

} 