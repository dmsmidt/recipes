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
        $all_args = $recipe->hasParent() ? '$parent_id' : '';
        $parent_name = $recipe->hasParent() ? $recipe->parent : null ;
        $plugins = '';
        $select = '->selectAll('.$all_args.')';
        if($recipe->nestable || $recipe->sortable){
            $plugins = '->with("javascripts", ["/cms/js/jquery.nestable.js"])';
            $select = '->selectTree('.$all_args.')';
        }
        //create file
        $path = app_path().'/Admin/Http/Controllers/'.$controllerClass.'Controller.php';
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

        if($recipe->hasParent()){
            $str .= PHP_EOL.<<<INDEX
    /**
	 * Display a listing of the resource.
	 * @param \$parent_id
	 * @return mixed
	 */
	public function index(\$parent_id)
	{
        \$data = \$this->{$controllerName}{$select};
        return view('admin')
            {$plugins}
            ->nest('center','main.index',compact('data'));
	}

INDEX;
        }else{
            $str .= PHP_EOL.<<<INDEX
    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        \$data = \$this->{$controllerName}{$select};
        return view('admin')
            {$plugins}
            ->nest('center','main.index',compact('data'));
	}

INDEX;
        }

        $str .= PHP_EOL.<<<CREATE
	/**
	 * Show the form for creating a new resource.
	 * @return mixed
	 */
	public function create()
	{
        return view('admin')->nest('center','main.form');
	}

CREATE;

        if($recipe->hasParent()){
            $str .= PHP_EOL.<<<STORE
	/**
     * @param {$controllerClass}Request \$request
     * @param \$parent_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store({$controllerClass}Request \$request, \$parent_id)
	{
        \$this->{$controllerName}->add(\$request->input(), \$parent_id);
        return redirect('admin/{$parent_name}/'.\$parent_id.'/{$moduleName}');
	}

STORE;
        }else{
            $str .= PHP_EOL.<<<STORE
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
        }

        $str .= PHP_EOL.<<<SHOW
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
        if($recipe->hasParent()){
            $str .= PHP_EOL.<<<EDIT
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  \$parent_id
	 * @param int \$id
	 * @return mixed
	 */
	public function edit(\$parent_id, \$id)
	{
        \$data = \$this->{$controllerName}->selectById(\$parent_id, \$id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

EDIT;
        }else{
            $str .= PHP_EOL.<<<EDIT
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  \$id
	 * @return mixed
	 */
	public function edit(\$id)
	{
        \$data = \$this->{$controllerName}->selectById(\$id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

EDIT;
        }

        $redirect = $recipe->hasParent() ? '\'admin/'.$recipe->parent.'/\'.$parent_id.\'/'.$recipe->moduleName.'\'' : '\'admin/'.$recipe->moduleName.'\'';
        if($recipe->hasParent()){
            $str .= PHP_EOL.<<<UPDATE
	/**
     * Update the specified resource in storage.
     * @param {$controllerClass}Request \$request
     * @param int \$parent_id
     * @param int \$id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update({$controllerClass}Request \$request, \$parent_id, \$id)
	{
        \$this->{$controllerName}->update(\$request->input(), \$id);
        return redirect({$redirect});
	}

UPDATE;
        }else{
            $str .= PHP_EOL.<<<UPDATE
	/**
     * Update the specified resource in storage.
     * @param {$controllerClass}Request \$request
     * @param \$id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update({$controllerClass}Request \$request, \$id)
	{
        \$this->{$controllerName}->update(\$request->input(), \$id);
        return redirect({$redirect});
	}

UPDATE;
        }

        if($recipe->hasParent()){
            $str .= PHP_EOL.<<<DESTROY
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  \$parent_id
	 * @param  int  \$id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(\$parent_id, \$id)
	{
        \$this->{$controllerName}->delete(\$parent_id, \$id);
        return redirect()->back();
	}

DESTROY;
        }else{
            $str .= PHP_EOL.<<<DESTROY
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  \$id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(\$id)
	{
        \$this->{$controllerName}->delete(\$id);
        return redirect()->back();
	}

DESTROY;
        }

    $str .= PHP_EOL.<<<END
}
END;
        if(fwrite($file,$str)){
            return true;
        }
        return false;
    }

    public function remove($name){
        $controllerClass = studly_case(str_singular($name));
        $path = app_path().'/Admin/Http/Controllers/'.$controllerClass.'Controller.php';
        if(unlink($path)){
            $path = app_path().'/Admin/Http/Requests/'.$controllerClass.'Request.php';
        }
        return unlink($path);
    }


} 