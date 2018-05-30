<?php namespace App\Admin\Form;


class Textarea extends FormField{

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
        return view('form.textarea',['field' => $this->properties])
            ->render();
    }

} 