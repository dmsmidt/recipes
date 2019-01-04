<?php

namespace App\Admin\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Recipe;
use DB;

class PurgeUnusedImages implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Remove uploaded images from /uploads
         */
        $uploads_dir = storage_path('app/public/uploads');
        $files = array_diff( scandir($uploads_dir), ['..','.']);
        \Log::debug('files in uploads: '.print_r($files,true));
        foreach($files as $file){
            if(strpos($file,'.') !== false){
                $aFileParts = explode('.',$file);
                if(last($aFileParts) == 'jpg' || last($aFileParts) == 'png' || last($aFileParts) == 'gif' || last($aFileParts) == 'pdf' || last($aFileParts) == 'webp' || last($aFileParts) == 'tiff'){
                    unlink($uploads_dir.'/'.$file);
                }
            }
        }
        
        /**
         * Select all the recipes with image inputs with a template 
         */
        $recipes = Recipe::all();
        $image_recipes = [];
        foreach($recipes as $_recipe){
            $recipe = Recipe::get($_recipe['name']);
            $find_image_input = $recipe->imageInputFields();
            if(count($find_image_input)){
                foreach($find_image_input as $field){
                    if(!in_array($_recipe['name'], $image_recipes) && isset($recipe->fields[$field]['image_template']) ){
                        $image_recipes[] = $_recipe['name'];
                    }    
                }
            }
        }

        /**
         * Find all used image id's in related image tables
         */
        $image_ids = [];
        foreach($image_recipes as $recipe_name){
            $result = DB::select( DB::raw("SELECT `image_id` FROM image_".str_singular($recipe_name)."") );
            if(count($result)){
                foreach($result as $row){
                    $image_ids[] = $row->image_id;
                }
            }
        }

        /**
         * Select all unused images
         */
        $result = DB::table("images")->select('*')->whereNotIn('id', $image_ids)->get();
        if(count($result)){
            /**
             * Remove all records and files of unused images 
             */
            $standard_formats = ['thumb','preview'];
            $template_formats = [];
            foreach($result as $image){
                Image::find($image->id)->delete();
                if(file_exists( storage_path('app/public/uploads').'/'.$image->filename )){
                    unlink(storage_path('app/public/uploads').'/'.$image->filename);
                }else{
                    \Log::debug('Image to purge not found: '.storage_path('app/public/uploads').'/'.$image->filename);
                }
                if(!array_key_exists($image->image_template,$template_formats)){
                    $formats = DB::table('image_formats')->select('*')->where('image_template', $image->image_template)->get();
                    if(count($formats)){
                        foreach($formats as $format){
                            $template_formats[$image->image_template][] = $format->name;
                        }
                        $template_formats[$image->image_template] = array_merge($template_formats[$image->image_template],$standard_formats);
                    }
                    foreach($template_formats[$image->image_template] as $path){
                        if(file_exists( storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename )){
                            unlink(storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename);
                        }else{
                            \Log::debug('Not found: '.storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename);
                        }
                    }
                    //\Log::debug('Template formats: '.print_r($template_formats,true));
                }else{
                    foreach($template_formats[$image->image_template] as $path){
                        if(file_exists( storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename )){
                            unlink(storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename);
                        }else{
                            \Log::debug('Not found: '.storage_path('app/public/uploads').'/'.$image->image_template.'/'.$path.'/'.$image->filename);
                        }
                    }
                }
            }
            //\Log::debug('Format_array: '.print_r($template_formats,true));
        }else{
            \Log::debug('No images to purge.');
        }

    }

}
