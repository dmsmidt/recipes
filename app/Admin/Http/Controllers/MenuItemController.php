<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\MenuItemRequest;
use App\Admin\Repositories\Contracts\IMenuItemRepository;

class MenuItemController extends AdminController {

    protected $menu_item;

    public function __construct(IMenuItemRepository $menu_item){
        $this->menu_item = $menu_item;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->menu_item->selectTree();
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
     * @param MenuItemRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MenuItemRequest $request)
	{
        $this->menu_item->add($request->input());
        return redirect('admin/menus/'.$request->input('menu_id').'/menu_items');
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
	public function edit($menu_id, $id)
	{
        $data = $this->menu_item->selectById($menu_id, $id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MenuItemRequest $request, $menu_id, $id)
	{
        $this->menu_item->update($request->input(), $id);
        return redirect('admin/menus/'.$request->input('menu_id').'/menu_items');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($menu_id, $id)
	{
        $this->menu_item->delete($menu_id, $id);
        return redirect()->back();
	}

}