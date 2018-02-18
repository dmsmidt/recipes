<?php namespace App\Admin\Creators;

use Recipe;

class Repository {

    /**
     * creates the repository and interface
     * @param $name
     * @return bool
     */
    public function create($name){
        $repository = studly_case(str_singular($name));
        $recipe = Recipe::get($name);
        $save_translations = "";
        $delete_translations = "";
        if($recipe->hasTranslations()){
            $save_translations = "\$this->saveTranslations('".$name."',\$input, \$model->id);";
            $delete_translations = "\$this->deleteTranslations('".$name."',\$id);";
        }
        $selectAll = $recipe->nestable || $recipe->sortable ? 'selectTree()' : 'selectAll()';
        $hierarchy = $recipe->nestable || $recipe->sortable ? '->toHierarchy()->toArray()' : '->toArray()';
        $path = app_path().'/Admin/Repositories/'.$repository.'Repository.php';
        $file = fopen($path,'w+');
        $extends = 'BaseRepository';
        $use = 'use App\Admin\Repositories\Contracts\I'.$repository.'Repository;'.PHP_EOL;
        $use .= 'use App\\Models\\'.$repository.';';
        $str = <<<START
<?php namespace App\Admin\Repositories;

{$use}

class {$repository}Repository extends {$extends} implements I{$repository}Repository{

START;

        $str .= PHP_EOL.<<<ALL
    public function {$selectAll}{
        return {$repository}::all(){$hierarchy};
    }

ALL;
        $params = isset($recipe->parent_table) && !empty($recipe->parent_table) ? '$parent_id, $id' : '$id';
        $str .= PHP_EOL.<<<BYID
    public function SelectById({$params}){
        return {$repository}::find(\$id);
    }

BYID;

        $str .= PHP_EOL.<<<ADD
    public function add(\$input){
        \$model = new {$repository};
        \$model->fill(\$input)->save();
        {$save_translations}
    }

ADD;

        $str .= PHP_EOL.<<<UPDATE
    public function update(\$input, \$id){
        \$model = {$repository}::find(\$id);
        \$model->fill(\$input)->save();
        {$save_translations}
    }

UPDATE;
        $params = isset($recipe->parent_table) && !empty($recipe->parent_table) ? '$parent_id, $id' : '$id';
        $str .= PHP_EOL.<<<DELETE
    public function delete({$params}){
        \$model = {$repository}::find(\$id);
        \$model->delete();
        {$delete_translations}
    }

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
        $path = app_path().'/Admin/Repositories/'.$repository.'Repository.php';
        return unlink($path);
    }

} 