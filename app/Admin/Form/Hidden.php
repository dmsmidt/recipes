<?php namespace App\Admin\Form;

class Hidden extends FormField{

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
        return view('form.hidden',['field' => $this->properties])
            ->render();
    }

} 