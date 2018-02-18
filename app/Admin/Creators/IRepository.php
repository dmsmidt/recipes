<?php namespace App\Admin\Creators;

use Recipe;

class IRepository {

    /**
     * creates the repository and interface
     * @param $name
     * @return bool
     */
    public function create($name){
        $repository = studly_case(str_singular($name));
        $recipe = Recipe::get($name);
        $params_all = isset($recipe->parent_table) && !empty($recipe->parent_table) ? '$parent_id = null' : '';
        $selectAll = $recipe->nestable || $recipe->sortable ? 'selectTree('.$params_all.');' : 'selectAll('.$params_all.');';
        $path = app_path().'/Admin/Repositories/Contracts/I'.$repository.'Repository.php';
        $file = fopen($path,'w+');
        $str = <<<START
<?php namespace App\Admin\Repositories\Contracts;

interface I{$repository}Repository{

    public function {$selectAll}

START;

        $params = isset($recipe->parent_table) && !empty($recipe->parent_table) ? '$parent_id, $id' : '$id';
        $str .= PHP_EOL.<<<BYID
    public function SelectById({$params});

BYID;

        $str .= PHP_EOL.<<<ADD
    public function add(\$input);

ADD;

        $str .= PHP_EOL.<<<UPDATE
    public function update(\$input, \$id);

UPDATE;

        $params = isset($recipe->parent_table) && !empty($recipe->parent_table) ? '$parent_id, $id' : '$id';
        $str .= PHP_EOL.<<<DELETE
    public function delete({$params});

DELETE;

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }

    public function remove($name){
        $repository = studly_case(str_singular($name));
        $path = app_path().'/Admin/Repositories/Contracts/I'.$repository.'Repository.php';
        return unlink($path);
    }


} 