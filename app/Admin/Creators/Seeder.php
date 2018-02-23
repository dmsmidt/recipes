<?php namespace App\Admin\Creators;

use Recipe;

class Seeder {

    /**
     * creates the model
     * @param $name
     * @return bool
     */
    public function create($name){
        $class = studly_case($name).'Seeder';
        $path = 'database/seeds/'.$class.'.php';
        $file = fopen($path,'w+');
        $recipe = Recipe::get($name);
        $table = $recipe->moduleName;
        $fields = $recipe->fields;
        //add fields from the recipe
        $fieldkeys = ' ['.PHP_EOL;
        foreach($fields as $key => $field){
            if($key != 'id' && $field['type'] != 'foreign'){
                $fieldkeys .= '             "'.$key.'" => "",'.PHP_EOL;
            }
        }

        //add fields for sortable or nestable
        if($recipe->sortable || $recipe->nestable){
            $fieldkeys .= '             "parent_id" => "",'.PHP_EOL;
            $fieldkeys .= '             "lft" => "",'.PHP_EOL;
            $fieldkeys .= '             "rgt" => "",'.PHP_EOL;
            $fieldkeys .= '             "level" => "",'.PHP_EOL;
        }
        //add fields for active and protect field
        if($recipe->activatable){
            $fieldkeys .= '             "active" => "",'.PHP_EOL;
        }
        if($recipe->protectable){
            $fieldkeys .= '             "protect" => "",'.PHP_EOL;
        }
        $fieldkeys .= '             ],'.PHP_EOL;
        $str = <<<START
<?php

use Illuminate\Database\Seeder;

class {$class} extends Seeder {

    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        \$insert = [
            {$fieldkeys}
        ];
        DB::table('{$table}')->insert(\$insert);
    }
}

START;

        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }


} 