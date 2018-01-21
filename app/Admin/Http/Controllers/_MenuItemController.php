<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\MenuRequest;
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
     * @param $menu_id
     * @return $this
     */
    public function index($menu_id)
	{
        $data = $this->menu_item->selectTree($menu_id);
		return view($this->layout)
            ->with("javascripts", ["/cms/js/jquery.nestable.js"])
            ->nest('center','cms.includes.index',compact('data'));
	}

	/**
	 * Show the form for creating a new resource item.
	 * @return Response
	 */
	public function create()
	{
        return view($this->layout)->nest('center','cms.includes.form');
	}

    /**
     * Save the newly added resource item.
     * @param MenuItemRequest $request
     * @param $menu_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MenuItemRequest $request, $menu_id)
	{
        $this->menu_item->add($request->input(), $menu_id);
        return redirect('admin/menus/'.$menu_id.'/menu_items');
	}

    /**
     * @param $id
     */
    public function show($id)
	{
        //
	}

    /**
     * Show the form for editing the specified resource item.
     * @param $menu_id
     * @param $id
     * @return $this
     */
    public function edit($menu_id, $id)
	{
        $data = $this->menu_item->SelectById($id);
        return view($this->layout)->nest('center','cms.includes.form',compact('data'));
	}

    /**
     * Update the resource item
     * @param MenuRequest $request
     * @param $menu_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MenuRequest $request, $menu_id, $id)
	{
        $this->menu_item->update($request->input(), $id);
        return redirect('admin/menus/'.$menu_id.'/menu_items');
	}

    /**
     * Remove the specified resource from storage.
     * @param $menu_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($menu_id, $id)
	{
        $this->menu_item->delete($menu_id, $id);
        return redirect()->back();
	}


}
