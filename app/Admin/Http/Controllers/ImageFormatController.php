<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ImageFormatRequest;
use App\Admin\Repositories\Contracts\IImageFormatRepository;

class ImageFormatController extends AdminController {

    protected $image_format;

    public function __construct(IImageFormatRepository $image_format){
        $this->image_format = $image_format;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->image_format->selectAll();
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
     * @param ImageFormatRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImageFormatRequest $request)
	{
        $this->image_format->add($request->input());
        return redirect('admin/image_formats');
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
        $data = $this->image_format->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param ImageFormatRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImageFormatRequest $request, $id)
	{
        $this->image_format->update($request->input(), $id);
        return redirect('admin/image_formats');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->image_format->delete($id);
        return redirect()->back();
	}

}