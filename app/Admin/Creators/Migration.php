<?php namespace App\Admin\Creators;

use App\Admin\Types;
use Recipe;

class Migration {

    /**
     * creates the model
     * @param $name
     * @return bool
     */
    public function create($name){

        $recipe = Recipe::get($name);
        $time_prefix = date('Y_n_j_His');
        $_table = $recipe->moduleName;
        $class = 'Create'.studly_case($_table).'Table';
        //create the file
        $filename = $time_prefix.'_create_'.$_table.'_table.php';
        $path = base_path().'/database/migrations/'.$filename;
        $file = fopen($path,'w+');
        $fields = $recipe->fields;
        $schema_rows = '';
        //define table field schema or foreign relation
        foreach($fields as $key=>$fielddata){
            if(isset($fielddata['type']) && !empty($fielddata['type']))
            {
                //fields
                $field_type = $fielddata['type'] == 'string' ? 'Varchar' : studly_case(($fielddata['type']));
                //all types except foreign
                if($field_type !== 'Foreign'){
                    $typeclass = 'App\\Admin\\Types\\'.$field_type;
                    $type = new $typeclass($key,$fielddata);
                    $schema_rows .= $type->addSchema($_table);
                //except foreign types when cascade is true
                }elseif($field_type == 'Foreign' && isset($fielddata['cascade']) && $fielddata['cascade'] == true ){
                    $typeclass = 'App\\Admin\\Types\\'.$field_type;
                    $type = new $typeclass($key,$fielddata);
                    $schema_rows .= $type->addSchema($_table);
                }
            }
        }

        //many_many pivot table
        if(isset($recipe->many_many) && count($recipe->many_many)){
            $pivot_schema = '';
            foreach($recipe->many_many as $key => $value){
                //$ref_arr = explode('.',$value);
                //$pivot_table = $ref_arr[0];
                $tables = [];
                //collect related tables
                $tables[] = $value['table'];
                $tables[] = $recipe->moduleName;
                sort($tables);
                $pivot_table = implode('_', $tables);
                //echo '<pre>'.$pivot_table.'</pre>';
                //die();
                $reference = str_singular($recipe->moduleName).'_id';
                $foreign_key = str_singular($value['table']).'_id';
                $pivot_schema .= <<<PIVOT
Schema::create('{$pivot_table}', function(\$table)
	    {
            \$table->increments('id');
            \$table->integer('{$reference}')->unsigned();
            \$table->integer('{$foreign_key}')->unsigned();
		});

PIVOT;
            }

        }

        //sortable
        if(isset($recipe->sortable) && $recipe->sortable){
            $type = new Types\Nestable();
            $schema_rows .= $type->addSchema($_table);
        }
        //nestable
        if(isset($recipe->nestable) && $recipe->nestable){
            $type = new Types\Nestable();
            $schema_rows .= $type->addSchema($_table);
        }
        //activatable
        if(isset($recipe->activatable) && $recipe->activatable){
            $type = new Types\Activatable();
            $schema_rows .= $type->addSchema($_table);
        }
        //protectable
        if(isset($recipe->protectable) && $recipe->protectable){
            $type = new Types\Protectable();
            $schema_rows .= $type->addSchema($_table);
        }
        //timestamps created updated
        if(isset($recipe->timestamps) && $recipe->timestamps){
            $type = new Types\Timestamps();
            $schema_rows .= $type->addSchema($_table);
        }
        $schema = <<<SCHEMA
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class {$class} extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('{$_table}', function(\$table)
	    {
		//UP
		});

		//PIVOT
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('{$_table}');
	}
}
SCHEMA;
        $schema = str_replace('//UP',$schema_rows,$schema);
        if(isset($pivot_schema)){
            $schema = str_replace('//PIVOT',$pivot_schema,$schema);
        }else{
            $schema = str_replace('//PIVOT','',$schema);
        }
        if(fwrite($file,$schema)){
            return true;
        }
        return false;
    }

} 