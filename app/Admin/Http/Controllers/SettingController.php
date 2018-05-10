<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\SettingRequest;
use App\Admin\Repositories\Contracts\ISettingRepository;

class SettingController extends AdminController {

    protected $setting;

    public function __construct(ISettingRepository $setting){
        $this->setting = $setting;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->setting->selectTree();
        return view('admin')
            ->nest('center','main.settings',compact('data'));
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
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SettingRequest $request)
	{
        //
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
        $data = $this->setting->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SettingRequest $request, $id)
	{
        $this->setting->update($request->input(), $id);
        return redirect('admin/settings');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->setting->delete($id);
        return redirect()->back();
	}

}