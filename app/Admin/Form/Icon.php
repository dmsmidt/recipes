<?php namespace App\Admin\Form;

class Icon extends FormField{

    public function __construct($formfield){
        $this->build($formfield);
    }

    public function view()
    {
        return '<div class="fa '.$this->properties['value'].'"></div>';
    }

    public function input()
    {
        return view('form.text',['field' => $this->properties])
            ->render();
    }

    public function iconSelector($data){
        $_icons = 'Admin\\Library\\Icons';
        $icons = new $_icons();
        $select = [];
        $n = 0;
        foreach($icons->icons as $icon){
            $current = $data['current'] == $icon ? 'active' : '';
            $select['icons'][$n]['current'] = $current;
            $select['icons'][$n]['icon'] = $icon;
            $n++;
        }
        $select['script'] = '<script>$(".icon").click(function(){
                selectIcon(this,\''.$data['btn_id'].'\',\''.$data['current'].'\',\''.$data['source'].'\');
            });</script>';
        $selector = \View::make('cms.form.iconSelector',["selector" => $select])->render();
        return $selector;
    }
} 