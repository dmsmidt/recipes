<?php namespace App\Admin\Creators;

class Recipe {

    /**
     * creates the model
     * @param $name
     * @return bool
     */
    public function create($_recipe)
    {
        $name = studly_case(str_singular($_recipe->moduleName));
        $filename = $name.'.php';
        $path = app_path().'/Admin/Recipes/'.$filename;
        $file = fopen($path,'w+');
        $str = <<<START
<?php namespace App\Admin\Recipes;

use App\Admin\Recipes\Traits\Ingredients;

class {$name} extends Recipe{

    use Ingredients;

    public \$moduleName = '{$_recipe->moduleName}';
    public \$parent = '{$_recipe->parent}';

START;
        if(isset($_recipe->fields) && count($_recipe->fields)){
            $fields = $this->writeFields($_recipe->fields);
            $str .= <<<FIELDS
    public \$fields = [
    {$fields}
    ];
FIELDS;
        }
        $str .= $this->writeRecipeOptions($_recipe);
        $str .= $this->writeRelations($_recipe);

        $str .= <<<CLOSING


    /**
     * @return mixed
     */
    public function __construct(){
        return (object)\$this;
    }

}
CLOSING;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
        //dd($str);
    }

    private function writeFields($fields)
    {
        $str = '';
        foreach ($fields as $name => $field) {
            $str .= <<<NAME

            "{$name}" => [
NAME;
            if (isset($field['type']) && !empty($field['type'])) {
                $str .= <<<TYPE

                            "type" => "{$field['type']}",
TYPE;
            }
            if (isset($field['length']) && !empty($field['length'])) {
                $str .= <<<LENGTH

                            "length" => {$field['length']},
LENGTH;
            }
            if (isset($field['decimals']) && !empty($field['decimals'])) {
                $str .= <<<DECIMALS

                            "decimals" => {$field['decimals']},
DECIMALS;
            }
            if (isset($field['set']) && !empty($field['set'])) {
                $str .= <<<SET

                            "set" => [
SET;
                $set = explode(',', str_replace(' ', '', $field['set']));
                foreach ($set as $val) {
                    $str .= <<<SETOPTIONS

                                        "{$val}",
SETOPTIONS;
                }
                $str .= <<<SETEND

                                    ]
SETEND;
            }
            if (isset($field['default']) && $field['default'] != '') {
                $str .= <<<DEFAULT

                            "default" => "{$field['default']}",
DEFAULT;
            }
            if (isset($field['unsigned']) && !empty($field['unsigned'])) {
                $str .= <<<UNSIGNED

                            "unsigned" => {$field['unsigned']},
UNSIGNED;
            }
            if (isset($field['unique']) && !empty($field['unique'])) {
                $str .= <<<UNIQUE

                            "unique" => {$field['unique']},
UNIQUE;
            }
            if (isset($field['nullable']) && !empty($field['nullable'])) {
                $str .= <<<NULLABLE

                            "nullable" => {$field['nullable']},
NULLABLE;
            }
            if (isset($field['relation']) && !empty($field['relation'])) {
                $str .= <<<RELATION

                            "relation" => "{$field['relation']}",
RELATION;
            }
            if (isset($field['primary']) && !empty($field['primary'])) {
                $str .= <<<PRIMARY

                            "primary" => {$field['primary']},
PRIMARY;
            }
            if (isset($field['label']) && !empty($field['label'])) {
                $str .= <<<LABEL

                            "label" => "{$field['label']}",
LABEL;
            }
            if (isset($field['max_files']) && !empty($field['max_files'])) {
                $str .= <<<MAX_FILES

                            "max_files" => "{$field['max_files']}",
MAX_FILES;
            }
            if (isset($field['image_template']) && !empty($field['image_template'])) {
                $str .= <<<IMAGE_TEMPLATE

                            "image_template" => "{$field['image_template']}",
IMAGE_TEMPLATE;
            }
            if (isset($field['input']) && !empty($field['input'])) {
                $str .= <<<INPUT

                            "input" => "{$field['input']}",
INPUT;
            }
            if (isset($field['rule']) && !empty($field['rule'])) {
                $str .= <<<RULE

                            "rule" => "{$field['rule']}",
RULE;
            }
            if (isset($field['options']) && !empty($field['options'])) {
                $str .= <<<INPUTOPTIONS

                            "options" => [
INPUTOPTIONS;
                if (isset($field['options']) && array_key_exists('table',$field['options'])) {
                    $str .= <<<TABLEOPTIONS

                                "table" => "{$field['options']['table']}",
                                "text" => "{$field['options']['label']}",
                                "value" => "{$field['options']['value']}",
                                "group_by" => "{$field['options']['group_by']}",
                                "filter_by" => "{$field['options']['filter_by']}"
TABLEOPTIONS;
                }else{
                    foreach ($field['options'] as $val) {
                        $str .= <<<ARRAYOPTIONS

                                [
                                    "text" => "{$val['text']}",
                                    "value" => "{$val['value']}"
                                ],
ARRAYOPTIONS;
                    }
                }
                $str .= <<<OPTIONSEND
            ]
OPTIONSEND;
            }
            $str .= <<<FIELDEND

                        ],
FIELDEND;
        }


        return $str;
    }

    private function writeRecipeOptions($_recipe){
        $str = '';
        if(count($_recipe->hidden)){
            $hidden = '';
            foreach($_recipe->hidden as $field){
                $hidden .= '"'.$field.'",';
            }
            $hidden = substr($hidden,0,-1);
            $str .= <<<HIDDEN

    public \$hidden = [{$hidden}];
HIDDEN;
        }else{
            $str .= <<<HIDDEN

    public \$hidden = [];
HIDDEN;
        }
        if(count($_recipe->summary)){
            $summary = '';
            foreach($_recipe->summary as $field){
                $summary .= '"'.$field.'",';
            }
            $summary = substr($summary,0,-1);
            $str .= <<<SUMMARY

    public \$summary = [{$summary}];
SUMMARY;
        }else{
            $str .= <<<SUMMARY

    public \$summary = [];
SUMMARY;
        }
        if(count($_recipe->fillable)){
            $fillable = '';
            foreach($_recipe->fillable as $field){
                $fillable .= '"'.$field.'",';
            }
            $fillable = substr($fillable,0,-1);
            $str .= <<<FILLABLE

    public \$fillable = [{$fillable}];
FILLABLE;
        }else{
            $str .= <<<FILLABLE

    public \$fillable = [];
FILLABLE;
        }
        if(count($_recipe->guarded)){
            $guarded = '';
            foreach($_recipe->guarded as $field){
                $guarded .= '"'.$field.'",';
            }
            $guarded = substr($guarded,0,-1);
            $str .= <<<GUARDED

    public \$guarded = [{$guarded}];
GUARDED;
        }else{
            $str .= <<<GUARDED

    public \$guarded = [];
GUARDED;
        }
        if(count($_recipe->scoped)){
            $scoped = '';
            foreach($_recipe->scoped as $field){
                $scoped .= '"'.$field.'",';
            }
            $scoped = substr($scoped,0,-1);
            $str .= <<<SCOPED

    public \$scoped = [{$scoped}];
SCOPED;
        }else{
            $str .= <<<SCOPED

    public \$scoped = [];
SCOPED;
        }
        $add = $_recipe->add ? 'true' : 'false';
        $edit = $_recipe->edit ? 'true' : 'false';
        $delete = $_recipe->delete ? 'true' : 'false';
        $activatable = $_recipe->activatable ? 'true' : 'false';
        $protectable = $_recipe->protectable ? 'true' : 'false';
        $sortable = $_recipe->sortable ? 'true' : 'false';
        $nestable = $_recipe->nestable ? 'true' : 'false';
        $timestamps = $_recipe->timestamps ? 'true' : 'false';
        $str .= <<<RECIPEOPTIONS

    public \$add = {$add};
    public \$edit = {$edit};
    public \$delete = {$delete};
    public \$activatable = {$activatable};
    public \$protectable = {$protectable};
    public \$sortable = {$sortable};
    public \$nestable = {$nestable};
    public \$timestamps = {$timestamps};
RECIPEOPTIONS;

        return $str;
    }

    private function writeRelations($_recipe){
        $str = '';
        if(isset($_recipe->has_one) && count($_recipe->has_one)){
            $relations = '';
            foreach($_recipe->has_one as $related){
                if(isset($related['table']) && !empty($related['table'])){
                    $inverse = $related['inverse'] ? 'true' : 'false';
                    $cascade = $related['cascade'] ? 'true' : 'false';
                    $with = $related['with'] ? 'true' : 'false';
                    $relations .= <<<RELATIONS
    [
                "table" => "{$related['table']}",
                "inverse" => {$inverse},
                "cascade" => {$cascade},
                "with" => {$with}
            ],
RELATIONS;

                }
            }
            $str .= <<<HASONE

    public \$has_one = [
        {$relations}
    ];
HASONE;

        }
        if(isset($_recipe->has_many) && count($_recipe->has_many)){
            $relations = '';
            foreach($_recipe->has_many as $related){
                if(isset($related['table']) && !empty($related['table'])){
                    $inverse = $related['inverse'] ? 'true' : 'false';
                    $cascade = $related['cascade'] ? 'true' : 'false';
                    $with = $related['with'] ? 'true' : 'false';
                    $relations .= <<<RELATIONS
    [
                "table" => "{$related['table']}",
                "inverse" => {$inverse},
                "cascade" => {$cascade},
                "with" => {$with}
            ],
RELATIONS;

                }
            }
            $str .= <<<HASMANY

    public \$has_many = [
        {$relations}
    ];
HASMANY;

        }
        if(isset($_recipe->many_many) && count($_recipe->many_many)){
            $relations = '';
            foreach($_recipe->many_many as $field => $related){
                if(isset($related['table']) && !empty($related['table'])) {
                    $cascade = $related['cascade'] ? 'true' : 'false';
                    $with = $related['with'] ? 'true' : 'false';
                    $relations .= <<<RELATIONS
    [
                "table" => "{$related['table']}",
                "cascade" => {$cascade},
                "with" => {$with}
            ],
RELATIONS;

                }
            }
            $str .= <<<MANYMANY

    public \$many_many = [
        {$relations}
    ];
MANYMANY;

        }
        return $str;
    }

} 