<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\MenuRequest;
use App\Admin\Repositories\Contracts\IMenuRepository;
use App\Models\Menu;

class MenuController extends AdminController {

    protected $menu;

    public function __construct(IMenuRepository $menu){
        $this->menu = $menu;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->menu->selectTree();
        return view('admin')
            ->with("javascripts", ["/cms/js/jquery.nestable.js"])
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
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MenuRequest $request)
	{
        $this->menu->add($request->input());
        return redirect('admin/menus');
	}

    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $data = $this->menu->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MenuRequest $request, $id)
	{
        $this->menu->update($request->input(), $id);
        return redirect('admin/menus');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->menu->delete($id);
        return redirect()->back();
	}

}