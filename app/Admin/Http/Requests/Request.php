<?php namespace App\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest {

    protected $recipe;

    /**
     * Method can be called when a model is being updated,
     * to prevent validation of existing unique field
     * @param $rules
     * @return array
     */
    protected function removeUnique($rules){
        $new_rules = [];
        foreach($rules as $key => $rule){
            $arr_rule = explode('|',$rule);
            $str_rule = '';
            foreach($arr_rule as $method){
                if(strpos($method,'unique') !== false){
                    continue;
                }
                $new_rules[$key] = $method;
            }
        }
        return $new_rules;
    }

    /**
     * Modifies the input, re-arranges foreign input arrays.
     * @param $input
     * @return mixed
     */
    protected function modifyInput($input){

        $foreign = $this->recipe->foreign();

        foreach($foreign as $name){
            if(!isset($input[$name])){
                continue;
            }else{
                $fields = array_keys($input[$name]);//Field names of related item
                $related = $input[$name];//The related input
                $reordered = [];
                foreach($related as $key => $values){
                    $reordered[$key] = array_values($values);
                }
                $rows = count($reordered[$fields[0]]);//Number of added rows
                $input_array = [];
                for($n = 0; $n < $rows; $n++){
                    foreach($fields as $field){
                        $input_array[$n][$field] = $reordered[$field][$n];
                    }
                }
                $input[$name] = $input_array;
            }
        }
        return $input;
    }



}
