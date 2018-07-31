<?php namespace App\Admin\Http\Controllers;

use App\Admin\Creators\ImageCreator as ImageCreator;
use Request;
use Session;
use Response;

class UploadController extends AdminController {

    protected $image;

    public function __construct(){
        parent::__construct();
    }

    public function upload($type){
        if($type == 'images'){
            return $this->uploadImage();
        }
    }

    public function uploadImage(){
        $extension = Request::file('file')->getClientOriginalExtension();
        $filename = Request::file('file')->getClientOriginalName();
        $template = Request::input('image_template');
        $name = substr($filename,0,strpos($filename,'.'));
        $filename = $name.'_'.rand(11111,99999).'.'.strtolower($extension);
        $upload_success = Request::file('file')->move('storage/uploads',$filename);
        if($upload_success) {
            $_imageCreator = new ImageCreator($template,$filename);
            $img = $_imageCreator->create();
            if(!$img){
                $this->dialog('data','callback');/////@TODO: parameters for data(f.e. error messages) and callback
            }else{
                $image_data = Request::all();
                $image_data['filename'] = $filename;
                $image_data['filesize'] = $_imageCreator->formatBytes($img->filesize());
                //add to database table
                $image_repo = 'App\\Admin\\Repositories\\ImageRepository';
                $imageRepo = new $image_repo();
                $Image = $imageRepo->add($image_data);
                $image_data['id'] = $Image->id;
                $image_data['alt'] = $filename;
                $languages = Session::get('language.active');
                foreach($languages as $key => $lang){
                    $image_data['alt_'.$lang['abbr'].''] = $filename;
                    $image_data['languages'][$key] = $lang['abbr'];
                }
                $image_data['image_template'] = $template;
                unset($image_data['_token']);//do not return _token
                $view = view('form.thumb', ['field' => $image_data['field'], 'row' => $image_data['row'], 'thumb'=>$image_data])->render();
            }
            return Response::json(['succes' => 200, 'thumb' => $view]);
        } else {
            return Response::json(['error' => 400]);
        }
        //$this->image->add($request->input());

    }


}