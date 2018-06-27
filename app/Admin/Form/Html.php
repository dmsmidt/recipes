<?php namespace App\Admin\Form;

class Html{

    protected $properties;

    /**
     * Add plugin assets needed for the form element here
     */
    public $plugins = [
        'javascript' => [
            //add javascript plugin paths here
            '/cms/vendor/tinymce/js/tinymce/tinymce.min.js',
            '/cms/vendor/tinymce/js/tinymce/jquery.tinymce.min.js'
        ],
        'css' => [
            //add plugin stylesheet paths here
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
        return view('form.html',['field' => $this->properties])
            ->render();
    }

} 