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
        $selectAll = $recipe->nestable || $recipe->sortable ? 'selectTree();' : 'selectAll();';
        $path = app_path().'/Admin/Repositories/Contracts/I'.$repository.'Repository.php';
        $file = fopen($path,'w+');
        $str = <<<START
<?php namespace App\Admin\Repositories\Contracts;

interface I{$repository}Repository{

    public function {$selectAll}

    public function SelectById(\$id);

    public function add(\$input);

    public function update(\$input, \$id);

    public function delete(\$id);
START;

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }


} 