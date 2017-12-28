<?php namespace App\Admin\Http\Requests;

use Recipe;
use Session;


class ConfigurationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
	    $this->recipe = Recipe::get('Configurations');
		$this->sanitize();
		Session::flash('input', $this->input());
        $rules =  $this->recipe->rules();
        switch($this->method()){
            case "PUT":
                return $this->removeUnique($rules);
            break;
            case "POST":
                return $rules;
            break;
            default:
                return $rules;
        }
	}

	/**
     * Modifies the input and re-arranges foreign field arrays
     */
    public function sanitize(){
        // Uncomment the lines below if the input request contains multiple related fields
        /*
        $input = $this->all();
        $this->replace($this->modifyInput($input));
        */
    }


}