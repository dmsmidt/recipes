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
        /**
         * Determine select all methods if for nestable(Baum) or standard(Eloquent)
         */
        if($recipe->hasParent()){
            $selectAll = $recipe->nestable || $recipe->sortable ? 'selectTree($parent_id = null)' : 'selectAll($parent_id = null)';
            $query = 'where(\''.str_singular($recipe->parent).'_id\', $parent_id)->get()';
        }else{
            $selectAll = $recipe->nestable || $recipe->sortable ? 'selectTree()' : 'selectAll()';
            $query = 'all()';
        }
        /**
         * Attach multiple if recipe has many_many relationships with an equal field name and
         * type is 'foreign' and input not is 'foreign'
         */
        $attach_multiple = '';
        if(isset($recipe->many_many) && count($recipe->many_many)){
            foreach($recipe->many_many as $relation){
                $related = $relation['table'];
                $added_foreign_ids = false;
                $n = 1;
                $foreigns = $recipe->foreign();
                foreach($foreigns as $field){
                    $is_image_field = false;
                    if(isset($recipe->fields[$field]['input']) && ($recipe->fields[$field]['input'] == 'images' || $recipe->fields[$field]['input'] == 'image')){
                        $is_image_field = true;
                    }
                    $attach_multiple .= $is_image_field && !$added_foreign_ids ? '$foreign_ids = [];'.PHP_EOL : '';
                    $attach_multiple .= !$is_image_field ? '$foreign_ids = [];'.PHP_EOL : '';
                    if(isset($recipe->fields[$field]['relation']) && $recipe->fields[$field]['relation'] == $related && $recipe->fields[$field]['input'] != 'foreign'){
                        $attach_multiple .= '        if(isset($input[\''.$field.'\'])){'.PHP_EOL;
                        $attach_multiple .= '            foreach($this->foreignToArray($input[\''.$field.'\']) as $foreign){'.PHP_EOL;
                        $attach_multiple .= '                $foreign_ids[] = $foreign[\'id\'];'.PHP_EOL;
                        $attach_multiple .= '            }'.PHP_EOL;
                        $attach_multiple .= '        }'.PHP_EOL;
                        $attach_multiple .= $is_image_field && count($foreigns) === $n ? '       $model->'.$related.'()->sync($foreign_ids);'.PHP_EOL : '';
                        $attach_multiple .= !$is_image_field ? '         $model->'.$related.'()->sync($foreign_ids);'.PHP_EOL : '';
                    }
                    $added_foreign_ids = true;
                    $n++;
                }
            }
        }

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
        return {$repository}::{$query}{$hierarchy};
    }

ALL;
        $params = $recipe->hasParent() ? '$parent_id, $id' : '$id';
        $str .= PHP_EOL.<<<BYID
    public function SelectById({$params}){
        return {$repository}::find(\$id);
    }

BYID;

        $str .= PHP_EOL.<<<ADD
    public function add(\$input){
        \$model = new {$repository};
        \$model->fill(\$input)->save();
        {$attach_multiple}
        {$save_translations}
        return \$model;
    }

ADD;

        $str .= PHP_EOL.<<<UPDATE
    public function update(\$input, \$id){
        \$model = {$repository}::find(\$id);
        \$model->fill(\$input)->save();
        {$attach_multiple}
        {$save_translations}
        return \$model;
    }

UPDATE;
        $params = $recipe->hasParent() ? '$parent_id, $id' : '$id';
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