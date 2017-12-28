<?php namespace App\Admin\Creators;

use Recipe;

class Model {

    /**
     * creates the model
     * @param $name
     * @return bool
     */
    public function create($name){
        $model = $name;
        $path = app_path().'/Models/'.$model.'.php';
        $file = fopen($path,'w+');
        $recipe = Recipe::get($model);
        $extends = $recipe->nestable || $recipe->sortable ? 'Node' : 'Model';
        $use = $recipe->nestable || $recipe->sortable ? 'Baum\Node;' : 'Illuminate\Database\Eloquent\Model;';
        $table = $recipe->table;
        $str = <<<START
<?php namespace App\Models;

use {$use}

class {$model} extends {$extends} {

    /**
     * The table to get the data from
     * @var string
     */
    protected \$table = '{$table}';

START;
        if($recipe->nestable || $recipe->sortable){
            $str .= PHP_EOL.<<<NESTEDSET
    /**
     * parent id in nestedset
     * @var string
     */
     protected \$parentColumn = 'parent_id';

     /**
     * left node index
     * @var string
     */
    protected \$leftColumn = 'lft';

    /**
     * right node index
     * @var string
     */
    protected \$rightColumn = 'rgt';

    /**
     * depth level of node
     * @var string
     */
    protected \$depthColumn = 'level';

NESTEDSET;
        }

        if($recipe->nestable || $recipe->sortable){
            $scoped = $recipe->scoped;
            if(isset($scoped) && count($scoped)){
                $scoped = implode('","',$scoped);
                $str .= PHP_EOL.<<<SCOPED
    /**
     * Columns which restrict what we consider our Nested Set list
     * @var array
     */
    protected \$scoped = ["{$scoped}"];

SCOPED;
            }
        }

        $hidden = $recipe->hidden;
        if(isset($hidden) && count($hidden)){
           $hidden = implode('","',$hidden);
           $str .= PHP_EOL.<<<HIDDEN
    /**
     * Fields that are hidden from view
     * @var array
     */
    protected \$hidden = ["{$hidden}"];

HIDDEN;
       }

        $fillable = $recipe->fillable;
        if(isset($fillable) && count($fillable)){
            $fillable = implode('","',$fillable);
            $str .= PHP_EOL.<<<FILLABLE
    /**
     * Fields allowed for mass assignment
     * @var array
     */
    protected \$fillable = ["{$fillable}"];

FILLABLE;
        }

        $guarded = $recipe->guarded;
        if($recipe->nestable){
            if(!in_array('parent_id',$guarded)){
                $guarded[] = 'parent_id';
            }
            if(!in_array('lft',$guarded)){
                $guarded[] = 'lft';
            }
            if(!in_array('rgt',$guarded)){
                $guarded[] = 'rgt';
            }
            if(!in_array('level',$guarded)){
                $guarded[] = 'level';
            }
        }
        if(isset($guarded) && count($guarded)){
            $guarded = implode('","',$guarded);
            $str .= PHP_EOL.<<<GUARDED
    /**
     * Fields disallowed for mass assignment
     * @var array
     */
    protected \$quarded = ["{$guarded}"];

GUARDED;
        }

        if(isset($recipe->has_one)){
            $has_one = $recipe->has_one;
            foreach($has_one as $name => $value){
                $func_name = camel_case($name);
                $ref = explode('.',$value);
                $relModel = studly_case($ref[0]);
                $reference = $ref[1];
                $str .= PHP_EOL.<<<HAS_ONE
    /**
     * Retrieve has_one relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function {$func_name}()
    {
        return \$this->hasOne('App\\Models\\{$relModel}','{$reference}');
    }

HAS_ONE;
            }
        }

        if(isset($recipe->has_many)){
            $has_many = $recipe->has_many;
            foreach($has_many as $name => $value){

                if($recipe->fields[$name]['input'] == 'language'){
                    $func_name = 'language';
                }else{
                    $func_name = camel_case($name);
                }
                $ref = explode('.',$value);
                $relModel = studly_case(str_singular($ref[0]));
                $reference = $ref[1];
                $str .= PHP_EOL.<<<HAS_MANY
    /**
     * Retrieve has_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function {$func_name}()
    {
        return \$this->hasMany('App\\Models\\{$relModel}', '{$reference}');
    }

HAS_MANY;
            }
        }

        if(isset($recipe->many_many)){
            $many_many = $recipe->many_many;
            foreach($many_many as $name => $value){
                $func_name = camel_case($name);
                $ref = explode('.',$value);
                $relModel = studly_case(str_singular($name));
                $reference = $ref[1];
                $foreign_key = str_singular($name).'_id';
                $str .= PHP_EOL.<<<MANY_MANY
    /*
     * Retrieve many_many relationships
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function {$func_name}()
    {
        return \$this->belongsToMany('App\\Models\\{$relModel}', '{$ref[0]}', '{$reference}', '{$foreign_key}');
    }

MANY_MANY;
            }
        }
        if(isset($recipe->timestamps)){
            $timestamps = $recipe->timestamps ? 'true' : 'false';
            $str .= PHP_EOL.<<<TIMESTAMPS
    /**
     * Manage fields for creation date and update date
     * @var bool
     */
    public \$timestamps = {$timestamps};

TIMESTAMPS;
        }

        if(isset($recipe->sortable)){
            $sortable = $recipe->sortable ? 'true' : 'false';
            $str .= PHP_EOL.<<<SORTABLE
    /**
     * Manage parent_id, lft, rgt and level to manage nested sets for sortable lists
     * @var bool
     */
    public \$sortable = {$sortable};

SORTABLE;
        }

        if(isset($recipe->nestable)){
            $nestable = $recipe->nestable ? 'true' : 'false';
            $str .= PHP_EOL.<<<NESTABLE
    /**
     * Manage parent_id, lft, rgt and level to manage nested sets for nested lists
     * @var bool
     */
    public \$nestable = {$nestable};

NESTABLE;
        }

        if(isset($recipe->activatable)){
            $activatable = $recipe->activatable ? 'true' : 'false';
            $str .= PHP_EOL.<<<ACTIVATABLE
    /**
     * Manage active field to turn on/off the model item
     * @var bool
     */
    public \$activatable = {$activatable};

ACTIVATABLE;
        }

        if(isset($recipe->protectable)){
            $protectable = $recipe->protectable ? 'true' : 'false';
            $str .= PHP_EOL.<<<PROTECTABLE
    /**
     * Manage protect field to lock modifications by user roles except for developer
     * @var bool
     */
    public \$protectable = {$protectable};

PROTECTABLE;
        }

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }


} 