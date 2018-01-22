<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\PostRequest;
use App\Admin\Repositories\Contracts\IPostRepository;

class PostController extends AdminController {

    protected $post;

    public function __construct(IPostRepository $post){
        $this->post = $post;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = $this->post->selectTree();
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
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PostRequest $request)
	{
        $this->post->add($request->input());
        return redirect('admin/posts');
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
        $data = $this->post->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request, $id)
	{
        $this->post->update($request->input(), $id);
        return redirect('admin/posts');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->post->delete($id);
        return redirect()->back();
	}

}