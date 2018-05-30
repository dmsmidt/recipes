<?php namespace App\Admin\Form;


class Image extends FormField{

    /**
     * Add plugin assets needed for the form element here
     */
    public $plugins = [
        'javascript' => [
            //add javascript plugin paths here
            /*'/cms/js/dropzone.js',*/
            '/cms/vendor/jcrop/js/jquery.Jcrop.min.js'
        ],
        'css' => [
            //add plugin stylesheet paths here
            '/cms/css/dropzone.css',
            '/cms/vendor/jcrop/css/jquery.Jcrop.css'
        ]
    ];

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
        //dd($this->properties);
        return view('form.image',['field' => $this->properties])
            ->render();
    }

}