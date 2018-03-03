<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ImageTemplateRequest;
use App\Admin\Repositories\Contracts\IImageTemplateRepository;

class ImageTemplateController extends AdminController {

    protected $image_template;

    public function __construct(IImageTemplateRepository $image_template){
        $this->image_template = $image_template;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->image_template->selectAll();
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
     * @param ImageTemplateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImageTemplateRequest $request)
	{
        $this->image_template->add($request->input());
        return redirect('admin/image_templates');
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
        $data = $this->image_template->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param ImageTemplateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImageTemplateRequest $request, $id)
	{
        $this->image_template->update($request->input(), $id);
        return redirect('admin/image_templates');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->image_template->delete($id);
        return redirect()->back();
	}

}