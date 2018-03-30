<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ImageRequest;
use App\Admin\Repositories\Contracts\IImageRepository;
use App\Admin\Creators\ImageCreator as ImageCreator;
use Session;
use Response;


class _ImageController extends AdminController {

    protected $image;

    public function __construct(IImageRepository $image){
        $this->image = $image;
        parent::__construct();
    }

    public function upload(ImageRequest $request){
        //echo '<pre>'.print_r($request->all(), true).'</pre>';
        //die();
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = $request->file('file')->getClientOriginalName();
        $image_template_id = $request->input('image_template_id');
        $name = substr($filename,0,strpos($filename,'.'));
        $filename = $name.'_'.rand(11111,99999).'.'.strtolower($extension);
        $upload_success = $request->file('file')->move('uploads',$filename);
        if($upload_success) {

            $_imageCreator = new ImageCreator($request->input('template'),$filename);
            $thumb = $_imageCreator->create($request);//returns thumbnail path or false on error
            if(!$thumb){
                $this->dialog('data','callback');/////@TODO: parameters for data(f.e. error messages) and callback
            }else{
                $image_data = $request->input();
                $image_data['filename'] = $filename;
                $image_data['filesize'] = $this->formatBytes($thumb->filesize());
                //add to database table
                $image_data['id'] = $this->ImageRepo->add($image_data);
                $image_data['alt'] = $filename;
                $languages = Session::get('language.active');
                foreach($languages as $key => $lang){
                    $image_data['alt_'.$lang['abbr'].''] = $filename;
                    $image_data['languages'][$key] = $lang['abbr'];
                }
                unset($image_data['_token']);//do not return _token
                $view = view('cms.form.thumb', ['field' => $image_data['field'], 'row' => $image_data['row'], 'thumb'=>$image_data])->render();
            }
            //return Response::json(['succes' => 200, 'thumb' => $view]);
        } else {
            return Response::json(['error' => 400]);
        }
        //$this->image->add($request->input());
        return redirect('admin/images');
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
        dd($request->all());
        //$this->image->add($request->input());
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