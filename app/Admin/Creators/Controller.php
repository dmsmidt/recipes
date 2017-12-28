<?php namespace App\Admin\Creators;

use Recipe;

class Controller {

    /**
     * creates the controller
     * @param $name
     * @return bool
     */
    public function create($name){
        $controllerClass = studly_case(str_singular($name));
        $controllerName = snake_case(str_singular($name));
        $moduleName = snake_case(str_plural($controllerName));
        $recipe = Recipe::get($moduleName);
        $nestable = $recipe->nestable || $recipe->sortable ? '->with("javascripts", ["/js/admin/jquery.nestable.js"])' : '';
        $plugins = '';
        $select = '->selectAll()';
        if($recipe->nestable || $recipe->sortable){
            $plugins = '->with("javascripts", ["/js/admin/jquery.nestable.js"])';
            $select = '->selectTree()';
        }
        $app_path = app_path();
        //create file
        $path = $app_path.'/Admin/Http/Controllers/'.$controllerClass.'Controller.php';
        $file = fopen($path,'w+');
        $extends = 'AdminController';
        //import classes
        $use = 'use App\Admin\Http\Requests\\'.$controllerClass.'Request;'.PHP_EOL;
        $use .= 'use App\Admin\Repositories\Contracts\I'.$controllerClass.'Repository;';
        //start code
        $str = <<<START
<?php namespace App\Admin\Http\Controllers;

{$use}

class {$controllerClass}Controller extends {$extends} {

    protected \${$controllerName};

    public function __construct(I{$controllerClass}Repository \${$controllerName}){
        \$this->{$controllerName} = \${$controllerName};
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        \$data = \$this->{$controllerName}{$select};
        return view('admin')
            {$plugins}
            ->nest('center','main.index',compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin')->nest('center','main.form');
	}

	/**
     * @param {$controllerClass}Request \$request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store({$controllerClass}Request \$request)
	{
        \$this->{$controllerName}->add(\$request->input());
        return redirect('admin/{$moduleName}');
	}

    /**
	 * Display the specified resource.
	 *
	 * @param  int  \$id
	 * @return Response
	 */
	public function show(\$id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  \$id
	 * @return Response
	 */
	public function edit(\$id)
	{
        \$data = \$this->{$controllerName}->selectById(\$id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest \$request
     * @param \$id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update({$controllerClass}Request \$request, \$id)
	{
        \$this->{$controllerName}->update(\$request->input(), \$id);
        return redirect('admin/{$moduleName}');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  \$id
	 * @return Response
	 */
	public function destroy(\$id)
	{
        \$this->{$controllerName}->delete(\$id);
        return redirect()->back();
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


} 