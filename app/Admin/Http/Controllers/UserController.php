<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\UserRequest;
use App\Admin\Repositories\Contracts\IUserRepository;

class UserController extends AdminController {

    protected $user;

    public function __construct(IUserRepository $user){
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Show an overview of the user resource
     * @return $this
     */
    public function index()
	{
        $data = $this->user->selectAll();
        return view('admin')->nest('center','main.index',compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create()
	{
        return view('admin')->nest('center','main.form');
	}

    /**
     * Add a new resource item
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
	{
        $this->user->add($request->all());
        return redirect('admin/users');
	}

	/**
	 * Display the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return $this
     */

    public function edit($id)
	{
        $data = $this->user->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

    /**
     * Update a specified resource
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request, $id)
	{
        $this->user->update($request->input(), $id);
        return redirect('admin/users');
	}

	/**
	 * Remove the specified resource from storage.
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->user->delete($id);
        return redirect()->back();
	}

}
