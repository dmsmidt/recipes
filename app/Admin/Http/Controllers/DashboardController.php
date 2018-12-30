<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\DashboardRequest;
use App\Admin\Repositories\Contracts\IDashboardRepository;
use App\Admin\Jobs\PurgeUnusedImages;

class DashboardController extends AdminController {

    protected $dashboard;

    public function __construct(IDashboardRepository $dashboard){
        $this->dashboard = $dashboard;
		parent::__construct();
		dispatch((new PurgeUnusedImages)->onQueue('purge_images'));
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
		$data = $this->dashboard->selectAll();
		return view('admin')
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
     * @param DashboardRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DashboardRequest $request)
	{
        $this->dashboard->add($request->input());
        return redirect('admin/dashboard');
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
	 * @return mixed
	 */
	public function edit($id)
	{
        $data = $this->dashboard->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param DashboardRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DashboardRequest $request, $id)
	{
        $this->dashboard->update($request->input(), $id);
        return redirect('admin/dashboard');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->dashboard->delete($id);
        return redirect()->back();
	}

}