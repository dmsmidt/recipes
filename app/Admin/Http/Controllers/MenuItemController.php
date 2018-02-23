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
	 * @param $parent_id
	 * @return mixed
	 */
	public function index($parent_id)
	{
        $data = $this->menu_item->selectTree($parent_id);
        return view('admin')
            ->with("javascripts", ["/cms/js/jquery.nestable.js"])
            ->nest('center','main.index',compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return mixed
	 */
	public function create()
	{
        return view('admin')->nest('center','main.form');
	}

	/**
     * @param MenuItemRequest $request
     * @param $parent_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MenuItemRequest $request, $parent_id)
	{
        $this->menu_item->add($request->input(), $parent_id);
        return redirect('admin/menus/'.$parent_id.'/menu_items');
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
	 * @param  int  $parent_id
	 * @param int $id
	 * @return mixed
	 */
	public function edit($parent_id, $id)
	{
        $data = $this->menu_item->selectById($parent_id, $id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param MenuItemRequest $request
     * @param int $parent_id
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MenuItemRequest $request, $parent_id, $id)
	{
        $this->menu_item->update($request->input(), $id);
        return redirect('admin/menus/'.$parent_id.'/menu_items');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $parent_id
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($parent_id, $id)
	{
        $this->menu_item->delete($parent_id, $id);
        return redirect()->back();
	}

}