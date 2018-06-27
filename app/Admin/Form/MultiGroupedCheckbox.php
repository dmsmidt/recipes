<?php namespace App\Admin\Form;


class MultiGroupedCheckbox{

    protected $properties;

    public function __construct($props){
        $this->properties = $props;
        return $this;
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
        //dd($this->properties);
        return view('form.multiGroupedCheckbox',['field' => $this->properties])
            ->render();
    }
} 