<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\SlideshowRequest;
use App\Admin\Repositories\Contracts\ISlideshowRepository;

class SlideshowController extends AdminController {

    protected $slideshow;

    public function __construct(ISlideshowRepository $slideshow){
        $this->slideshow = $slideshow;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->slideshow->selectAll();
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
     * @param SlideshowRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SlideshowRequest $request)
	{
        $this->slideshow->add($request->input());
        return redirect('admin/slideshows');
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
        $data = $this->slideshow->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param SlideshowRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SlideshowRequest $request, $id)
	{
        $this->slideshow->update($request->input(), $id);
        return redirect('admin/slideshows');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->slideshow->delete($id);
        return redirect()->back();
	}

}