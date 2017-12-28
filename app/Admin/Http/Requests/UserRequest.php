<?php namespace App\Admin\Http\Requests;

use Recipe;
use Session;


class UserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        //when user role is 'developer' id = 1
        if(Session::get('user.role_id') == 1){
            return true;
        }
        //when user role is 'administrator' id = 2
        elseif(Session::get('user.role_id') == 2 && $this->request->get('role_id') >= 2){
            return true;
        //when authorized user is editing own data
        }elseif(Session::get('user.id') == $this->request->get('id')){
            return true;
        }
        return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
	    $this->recipe = Recipe::get('users');
		$this->sanitize();
		Session::flash('input', $this->input());
        $rules =  $this->recipe->rules();
        switch($this->method()){
            case "PUT":
                $password = $this->request->get('password');
                if(empty($password)){
                    unset($rules['password']);
                    unset($rules['password_confirmation']);
                    $this->request->remove('password');
                    $this->request->remove('password_confirmation');
                }
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