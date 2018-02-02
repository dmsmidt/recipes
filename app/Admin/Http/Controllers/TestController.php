<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\TestRequest;
use App\Admin\Repositories\Contracts\ITestRepository;

class TestController extends AdminController {

    protected $test;

    public function __construct(ITestRepository $test){
        $this->test = $test;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->test->selectTree();
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
     * @param TestRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TestRequest $request)
	{
        $this->test->add($request->input());
        return redirect('admin/tests');
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
        $data = $this->test->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TestRequest $request, $id)
	{
        $this->test->update($request->input(), $id);
        return redirect('admin/tests');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->test->delete($id);
        return redirect()->back();
	}

}