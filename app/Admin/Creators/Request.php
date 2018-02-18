<?php namespace App\Admin\Creators;

use Recipe;

class Request {

    /**
     * creates the controller
     * @param $name
     * @return bool
     */
    public function create($name){
        $requestClass = studly_case(str_singular($name));
        $requestName = str_singular($name);
        $moduleName = str_plural($requestName);
        $recipe = Recipe::get($moduleName);
        //create file
        $path = app_path().'/Admin/Http/Requests/'.$requestClass.'Request.php';
        $file = fopen($path,'w+');
        //start code
        $str = <<<START
<?php namespace App\Admin\Http\Requests;

use Recipe;
use Session;


class {$requestClass}Request extends Request {

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
	    \$this->recipe = Recipe::get('{$moduleName}');
		\$this->sanitize();
		Session::flash('input', \$this->input());
        \$rules =  \$this->recipe->rules();
        switch(\$this->method()){
            case "PUT":
                return \$this->removeUnique(\$rules);
            break;
            case "POST":
                return \$rules;
            break;
            default:
                return \$rules;
        }
	}

	/**
     * Modifies the input and re-arranges foreign field arrays
     */
    public function sanitize(){
        // Uncomment the lines below if the input request contains multiple related fields
        /*
        \$input = \$this->all();
        \$this->replace(\$this->modifyInput(\$input));
        */
    }


START;

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }

    public function remove($name){
        $requestClass = studly_case(str_singular($name));
        $path = app_path().'/Admin/Http/Requests/'.$requestClass.'Request.php';
        return unlink($path);
    }

} 