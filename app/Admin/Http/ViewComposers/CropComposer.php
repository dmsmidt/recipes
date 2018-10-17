<?php namespace App\Admin\Http\ViewComposers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Lang;
use App\Admin\Services\AdminConfig as AdminConfig;
use App\Admin\Repositories\ImageFormatRepository;



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
        $size = getimagesize(base_path().'/storage/app/public/uploads/'.$data['image_template'].'/preview/'.$data['filename']);
        $data['preview_size'] = ['width' => $size[0], 'height' => $size[1]];
        //get the formats
        $image_format_repo = new ImageFormatRepository();
        $data['image_formats'] = $image_format_repo->selectByImage($data['image_template'], $data['id']);
        $view->nest('content','dialogs.crop',compact('data'));
    }

}