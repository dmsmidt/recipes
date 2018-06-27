<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ImageRequest;
use App\Admin\Repositories\Contracts\IImageRepository;
use Session;
use Response;
use App\Admin\Repositories\ImageTemplateRepository as ImageTemplate;

class ImageController extends AdminController {

    protected $image;

    public function __construct(IImageRepository $image){
        $this->image = $image;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->image->selectAll();
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
     * @param ImageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImageRequest $request)
	{
        $this->image->add($request->input());
        return redirect('admin/images');
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
        $data = $this->image->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param ImageRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImageRequest $request, $id)
	{
        $this->image->update($request->input(), $id);
        return redirect('admin/images');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->image->delete($id);
        return redirect()->back();
	}

}