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

START;

        $str .= <<<INDEX
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

INDEX;

        $str .= <<<CREATE
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin')->nest('center','main.form');
	}

CREATE;

        $str .= <<<STORE
	/**
     * @param {$controllerClass}Request \$request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store({$controllerClass}Request \$request)
	{
        \$this->{$controllerName}->add(\$request->input());
        return redirect('admin/{$moduleName}');
	}

STORE;

        $str .= <<<SHOW
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

SHOW;
        if(isset($recipe->parent_table) && !empty($recipe->parent_table)){
            $edit_params = '$'.str_singular($recipe->parent_table).'_id, $id';
        }else{
            $edit_params = '$id';
        }
        $str .= <<<EDIT
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  \$id
	 * @return Response
	 */
	public function edit(\$id)
	{
        \$data = \$this->{$controllerName}->selectById({$edit_params});
        return view('admin')->nest('center','main.form',compact('data'));
	}

EDIT;
        if(isset($recipe->parent_table) && !empty($recipe->parent_table)){
            $redirect = "'admin/".$recipe->parent_table."/'.\$request->input('".str_singular($recipe->parent_table)."_id').'/".$moduleName."'";
        }else{
            $redirect = "'admin/".$moduleName."'";
        }
        $str .= <<<UPDATE
	/**
     * Update the specified resource in storage.
     * @param RoleRequest \$request
     * @param \$id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update({$controllerClass}Request \$request, \$id)
	{
        \$this->{$controllerName}->update(\$request->input(), \$id);
        return redirect({$redirect});
	}

UPDATE;

        $str .= <<<DESTROY
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

DESTROY;

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }


} 