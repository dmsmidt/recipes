<?php namespace App\Admin\Creators;


class Translations {

    /**
     * creates the repository and interface
     * @param $name
     * @return bool
     */
    public function create($lang, $name){
        $path = base_path().'/resources/lang/'.$lang.'/'.$name.'.php';
        $file = fopen($path,'w+');
        $str = <<<START
<?php
return [
START;
    $str .= PHP_EOL.<<<END
];
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }
}