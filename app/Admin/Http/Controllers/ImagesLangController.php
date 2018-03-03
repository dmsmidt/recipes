<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ImagesLangRequest;
use App\Admin\Repositories\Contracts\IImagesLangRepository;

class ImagesLangController extends AdminController {

    protected $images_lang;

    public function __construct(IImagesLangRepository $images_lang){
        $this->images_lang = $images_lang;
        parent::__construct();
    }

    /**
	 * Display a listing of the resource.
	 * @return mixed
	 */
	public function index()
	{
        $data = $this->images_lang->selectAll();
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
     * @param ImagesLangRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImagesLangRequest $request)
	{
        $this->images_lang->add($request->input());
        return redirect('admin/images_langs');
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
        $data = $this->images_lang->selectById($id);
        return view('admin')->nest('center','main.form',compact('data'));
	}

	/**
     * Update the specified resource in storage.
     * @param ImagesLangRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImagesLangRequest $request, $id)
	{
        $this->images_lang->update($request->input(), $id);
        return redirect('admin/images_lang');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
        $this->images_lang->delete($id);
        return redirect()->back();
	}

}