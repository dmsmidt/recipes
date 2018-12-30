<?php namespace App\Admin\Recipes;

use App\Admin\Exceptions\RecipeException;
use App\Admin\Recipes\Traits\Ingredients;
use Schema;
use Lang;

class Recipe {

    use Ingredients;

    protected $recipe;

    /**
     * Select all existing recipes
     * @return array
     * @throws RecipeException
     */
    public function all(){
        $dir = app_path().'/Admin/Recipes';
        $recipeClassNames = array_diff(scandir($dir), array('..', '.', 'Recipe.php', 'backups', 'Traits'));
        $recipes = [];
        foreach($recipeClassNames as $key => $val){
            $recipeClassName = str_replace('.php','',$val);
            $recipe = snake_case(str_plural($recipeClassName));
            $_recipe = Recipe::get($recipe);
            $recipes[$key]['name'] = $recipe;
            $recipes[$key]['class'] = $recipeClassName;
            //check for table
            if(Schema::hasTable($_recipe->moduleName)){
                $recipes[$key]['table'] = true;
            }else{
                $recipes[$key]['table'] = false;
            }
            //check if model exists
            if(file_exists(app_path().'/Models/'.$recipeClassName.'.php')){
                $recipes[$key]['model'] = true;
            }else{
                $recipes[$key]['model'] = false;
            }
            //check for repository
            if(file_exists(app_path().'/Admin/Repositories/'.$recipeClassName.'Repository.php')){
                $recipes[$key]['repository'] = true;
            }else{
                $recipes[$key]['repository'] = false;
            }
            //check for controller
            if(file_exists(app_path().'/Admin/Http/Controllers/'.$recipeClassName.'Controller.php')){
                $recipes[$key]['controller'] = true;
            }else{
                $recipes[$key]['controller'] = false;
            }
            //check for request
            if(file_exists(app_path().'/Admin/Http/Requests/'.$recipeClassName.'Request.php')){
                $recipes[$key]['request'] = true;
            }else{
                $recipes[$key]['request'] = false;
            }
            //check for languages
            if(file_exists(base_path().'/resources/lang/'.Lang::getLocale().'/'.$recipe.'.php')){
                $recipes[$key]['translations'] = true;
            }else{
                $recipes[$key]['translations'] = false;
            }
        }
        return $recipes;
    }

    /**
     * Returns the Recipe object by modulename
     * @param $moduleName
     * @return mixed
     * @throws RecipeException
     */
    public function get($moduleName){
        $_recipe_singular = __NAMESPACE__.'\\'.studly_case(str_singular($moduleName));
        $_recipe_plural = __NAMESPACE__.'\\'.studly_case($moduleName);
        if(class_exists($_recipe_singular)){
            $this->recipe = new $_recipe_singular;
        }elseif(class_exists($_recipe_plural)){
            $this->recipe = new $_recipe_plural;
        }else{
            throw new RecipeException('The recipe "'.$_recipe_singular.'" or "'.$_recipe_plural.'" does not exist!');
        }
        return $this->recipe;
    }

    /**
     * Return existing database value types
     * @return array
     */
    public function types(){
        $dir_types = array_diff(scandir('../App/Admin/Types'), array('..', '.', 'Type.php'));
        $types = [];
        foreach($dir_types as $file){
            $types[] = str_replace('.php','',$file);
        }
        return $types;
    }

    /**
     * Builds the recipe by Recipe input configuration data
     * @param $formdata
     * @return object
     */
    public function build($formdata){
        $recipe = [
            'moduleName' => $formdata['name'],//required
            'parent' => $formdata['parent'],
            'add' => isset($formdata['add'])&&$formdata['add'] ? true : false,
            'edit' => isset($formdata['edit'])&&$formdata['edit'] ? true : false,
            'delete' => isset($formdata['delete'])&&$formdata['delete'] ? true : false,
            'activatable' => isset($formdata['activatable']) && $formdata['activatable'] ? true : false,
            'protectable' => isset($formdata['protectable']) && $formdata['protectable'] ? true : false,
            'sortable' => isset($formdata['sortable']) && $formdata['sortable'] && $formdata['sortable_levels'] == 'single' ? true : false,
            'nestable' => isset($formdata['sortable']) && $formdata['sortable'] && $formdata['sortable_levels'] == 'multiple' ? true : false,
            'timestamps' => isset($formdata['timestamps']) && $formdata['timestamps'] ? true : false,
        ];
        $aHidden = [];
        $aSummary = [];
        $aFillable = [];
        $aGuarded = [];
        $aScoped = [];

        /*FIELDS*/
        foreach($formdata['field'] as $field){

            if(isset($field['name']) && !empty($field['name'])){
                $recipe['fields'][$field['name']]['type'] = $field['type'];
                if(isset($field['input']) && !empty($field['input'])){
                    $recipe['fields'][$field['name']]['input'] = $field['input'];
                }
                if(isset($field['length']) && !empty($field['length'])){
                    $recipe['fields'][$field['name']]['length'] = $field['length'];
                }
                if(isset($field['decimals']) && !empty($field['decimals'])){
                    $recipe['fields'][$field['name']]['decimals'] = $field['decimals'];
                }
                if(isset($field['typeoptions']) && !empty($field['typeoptions'])){
                    $recipe['fields'][$field['name']]['set'] = $field['typeoptions'];
                }
                if(isset($field['unsigned']) && !empty($field['unsigned'])){
                    $recipe['fields'][$field['name']]['unsigned'] = $field['unsigned'] ? true : false;
                }
                if(isset($field['unique']) && !empty($field['unique'])){
                    $recipe['fields'][$field['name']]['unique'] = $field['unique'] ? true : false;
                }
                if(isset($field['default']) && $field['default'] != ''){
                    $recipe['fields'][$field['name']]['default'] = ''.$field['default'];
                }
                if(isset($field['nullable']) && !empty($field['nullable'])){
                    $recipe['fields'][$field['name']]['nullable'] = $field['nullable'] ? true : false;
                }
                if(isset($field['relation']) && !empty($field['relation'])){
                    $recipe['fields'][$field['name']]['relation'] = $field['relation'];
                }
                if(isset($field['primary']) && !empty($field['primary'])){
                    $recipe['fields'][$field['name']]['primary'] = $field['relation'] ? true : false;
                }
                if(isset($field['label']) && !empty($field['label'])){
                    $recipe['fields'][$field['name']]['label'] = $field['label'];
                }
                if(isset($field['max_files']) && !empty($field['max_files'])){
                    $recipe['fields'][$field['name']]['max_files'] = $field['max_files'];
                }
                if(isset($field['image_template']) && !empty($field['image_template'])){
                    $recipe['fields'][$field['name']]['image_template'] = $field['image_template'];
                }
                if(isset($field['input']) && !empty($field['input'])){
                    $recipe['fields'][$field['name']]['input'] = $field['input'];
                }
                if(isset($field['inputoptions']) && !empty($field['inputoptions'])){
                    if($field['inputoptions'] == 'db_table'){
                        $recipe['fields'][$field['name']]['options'] = [
                            'table' => $field['inputoptions_table'],
                            'label' => $field['inputoptions_label'],
                            'value' => $field['inputoptions_value'],
                            'group_by' => $field['inputoptions_group_by'],
                            'filter_by'=> $field['inputoptions_filter_by']
                        ];
                    }elseif($field['inputoptions'] == 'array'){
                        for($n = 0; $n < count($field['inputoptionslabel_array']); $n++){
                            $recipe['fields'][$field['name']]['options'][] = [
                                'text' => $field['inputoptionslabel_array'][$n],
                                'value' => $field['inputoptionsvalue_array'][$n]
                            ];
                        }
                    }
                }

                /* RULES */
                $rules = '';
                if(isset($field['rule|required']) && $field['rule|required']){
                    $rules .= 'required|';
                }
                if(isset($field['rule|accepted']) && $field['rule|accepted']){
                    $rules .= 'accepted|';
                }
                if(isset($field['rule|confirmed']) && $field['rule|confirmed']){
                    $rules .= 'confirmed|';
                }
                if(isset($field['rule|unique']) && $field['rule|unique']){
                    $rules .= 'unique:'.$field['uniquetable'].','.$field['uniquecolumn'].'|';
                }
                if(isset($field['rule|email']) && $field['rule|email']){
                    $rules .= 'email|';
                }
                if(isset($field['rule|image']) && $field['rule|image']){
                    $rules .= 'image|';
                }
                if(isset($field['rule|integer']) && $field['rule|integer']){
                    $rules .= 'integer|';
                }
                if(isset($field['rule|numeric']) && $field['rule|numeric']){
                    $rules .= 'numeric|';
                }
                if(isset($field['rule|date_format']) && !empty($field['rule|date_format'])){
                    $rules .= 'date_format:'.$field['rule|date_format'].'|';
                }
                if(isset($field['rule|size']) && !empty($field['rule|sizeval'])){
                    $rules .= 'size:'.$field['rule|sizeval'].'|';
                }
                if(isset($field['rule|min']) && !empty($field['rule|minval'])){
                    $rules .= 'min:'.$field['rule|minval'].'|';
                }
                if(isset($field['rule|max']) && !empty($field['rule|maxval'])){
                    $rules .= 'max:'.$field['rule|maxval'].'|';
                }
                if(isset($field['rule|regex']) && !empty($field['rule|regexval'])){
                    $rules .= 'regex:'.$field['rule|regexval'].'|';
                }
                $rules = substr($rules,0,-1);

                if(!empty($rules)){
                    $recipe['fields'][$field['name']]['rule'] = $rules;
                }
            }
            if(isset($field['hidden']) && $field['hidden']){$aHidden[] = $field['name'];}
            if(isset($field['summary']) && $field['summary']){$aSummary[] = $field['name'];}
            if(isset($field['fillable']) && $field['fillable']){$aFillable[] = $field['name'];}
            if(isset($field['guarded']) && $field['guarded']){$aGuarded[] = $field['name'];}
            if(isset($field['scoped']) && $field['scoped']){$aScoped[] = $field['name'];}
        }
        $recipe['hidden'] = $aHidden;
        $recipe['summary'] = $aSummary;
        $recipe['fillable'] = $aFillable;
        $recipe['guarded'] = $aGuarded;
        $recipe['scoped'] = $aScoped;

        /*RELATIONS*/
        //has_one
        if(isset($formdata['has_one']) && count($formdata['has_one'])){
            $recipe['has_one'] = [];
            foreach($formdata['has_one'] as $related){
                if(!isset($related['inverse'])){ $related['inverse'] = 0; }
                if(!isset($related['cascade'])){ $related['cascade'] = 0; }
                if(!isset($related['with'])){ $related['with'] = 0; }
                $recipe['has_one'][] = ["table" => $related['table'],
                                      "inverse" => $related['inverse'] ? 1 : 0,
                                      "cascade" => $related['cascade'] ? 1 : 0,
                                      "with"    => $related['with'] ? 1 : 0];
            }
        }
        //has_many
        if(isset($formdata['has_many']) && count($formdata['has_many'])){
            $recipe['has_many'] = [];
            foreach($formdata['has_many'] as $key => $related){
                if(isset($related['table'])){
                    $recipe['has_many'][$key]['table'] = $related['table'];
                    $inverse = isset($related['inverse']) && $related['inverse'] ? 1 : 0;
                    $recipe['has_many'][$key]['inverse'] = $inverse;
                    $cascade = isset($related['cascade']) && $related['cascade'] ? 1 : 0;
                    $recipe['has_many'][$key]['cascade'] = $cascade;
                    $with = isset($related['with']) && $related['with'] ? 1 : 0;
                    $recipe['has_many'][$key]['with'] = $with;
                }
            }
        }
        //many_many
        if(isset($formdata['many_many']) && count($formdata['many_many'])){
            $recipe['many_many'] = [];
            foreach($formdata['many_many'] as $key => $related){
                if(isset($related['table'])){
                    $recipe['many_many'][$key]['table'] = $related['table'];
                    $cascade = isset($related['cascade']) && $related['cascade'] ? 1 : 0;
                    $recipe['many_many'][$key]['cascade'] = $cascade;
                    $with = isset($related['with']) && $related['with'] ? 1 : 0;
                    $recipe['many_many'][$key]['with'] = $with;
                }
            }
        }
        return (object)$recipe;
    }

}