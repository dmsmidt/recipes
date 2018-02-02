<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\TestItemRequest;
use App\Admin\Repositories\Contracts\ITestItemRepository;

class TestItemController extends AdminController {

    protected $test_item;

    public function __construct(ITestItemRepository $test_item){
        $this->test_item = $test_item;
        parent::__construct();
    }
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->test_item->selectTree();
        return view('admin')
            ->with("javascripts", ["/js/admin/jquery.nestable.js"])
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
     * @param TestItemRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TestItemRequest $request)
	{
        $this->test_item->add($request->input());
        return redirect('admin/test_items');
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
        $data = $this->test_item->selectById($test_id, $id);
        return view('admin')->nest('center','main.form',compact('data'));
	}
	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TestItemRequest $request, $id)
	{
        $this->test_item->update($request->input(), $id);
        return redirect('admin/tests/'.$request->input('test_id').'/test_items');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->test_item->delete($id);
        return redirect()->back();
	}

}