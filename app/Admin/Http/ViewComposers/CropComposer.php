<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Lang;
use App\Models\Image;
use App\Admin\Services\AdminConfig as AdminConfig;



class CropComposer {

    protected $config;

    public function __construct(Route $route){
        $this->config = new AdminConfig();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->data;
        //get the true size of the preview image
        $size = getimagesize(public_path().'/uploads/'.$data['template'].'/preview/'.$data['filename']);
        $data['preview_size'] = ['width' => $size[0], 'height' => $size[1]];
        $data['default_size'] = ['width' => $this->config->get($data['template'].'_default_width'), 'height' => $this->config->get($data['template'].'_default_height')];
        //retrieve the image formats according to template from image config
        $data['image_formats'] = config('image')['image_formats'][$data['template']];
        $crop_formats = Image::find($data['id'])->formats->toArray();
        $data['crop_formats'] = $crop_formats;
        dd($data);
        $view->nest('content','main.crop',compact('data'));
    }

}