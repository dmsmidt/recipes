<?php namespace App\Admin\Http\Requests;


class RecipeRequest extends Request {

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
        $rules =  [
            "name" => "required",
            "table" => "required"
        ];
        return $rules;
	}

}
