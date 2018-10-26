<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\NewsRequest;
use App\Admin\Repositories\Contracts\INewsRepository;

class NewsController extends AdminController {

    protected $news;

    public function __construct(INewsRepository $news){
        $this->news = $news;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->news->selectTree();
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
     * @param NewsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NewsRequest $request)
	{
        $this->news->add($request->input());
        return redirect('admin/news');
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
        $data = $this->news->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param NewsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(NewsRequest $request, $id)
	{
        $this->news->update($request->input(), $id);
        return redirect('admin/news');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->news->delete($id);
        return redirect()->back();
	}

}