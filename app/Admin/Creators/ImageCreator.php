<?php

/**
 * Created by PhpStorm.
 * User: pazuur
 * Date: 24-10-2016
 * Time: 21:41
 */

namespace App\Admin\Creators;

use Image;
use File;
use App\Admin\Repositories\ImageFormatRepository as ImageFormat;
use App\Admin\Services\AdminConfig as AdminConfig;
use Log;

class ImageCreator
{

	protected $template;
	protected $filename;
	protected $config;

	public function __construct($template, $filename)
	{
		$this->template = $template;
		$this->filename = $filename;
		$this->config = new AdminConfig();
	}

	/**
	 * Create all possible image versions according to template and standard sizes like thumbnail and preview.
	 * @return bool
	 */
	public function create()
	{
        //save preview image
		if (!$this->savePreview()) {
			Log::warning('Preview image ' . $this->filename . ' could not be saved!');
			return false;//@TODO: Send error message back
		}
        //save all template formats
		if (!$this->saveTemplate()) {
			Log::warning('Template formats of image ' . $this->filename . ' could not be saved!');
			return false;//@TODO: Send error message back
		}
        //save thumbnail image
		return $this->saveThumb();
	}

	/**
	 * Create and save preview image (Largest original image (scaled to max limits) for preview in editing window.
	 * @return bool
	 */
	protected function savePreview()
	{
		$img = Image::make(base_path() . '/storage/app/public/uploads/' . $this->filename);
		$width = $img->width();
		$height = $img->height();
		$maxwidth = $this->config->get('images_max_width');
		$maxheight = $this->config->get('images_max_height');
		$quality = $this->config->get('image_quality');
		if ($width > $maxwidth) {
			$img->resize($maxwidth, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		} elseif ($height > $maxheight) {
			$img->resize(null, $maxheight, function ($constraint) {
				$constraint->aspectRatio();
			});
		} else {
            //
		}
		if ($this->checkPath(base_path() . '/storage/app/public/uploads/' . $this->template . '/preview')) {
			if ($img->save(base_path() . '/storage/app/public/uploads/' . $this->template . '/preview/' . $this->filename, $quality)) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	/**
	 * Creating and saving thumbnail. Return false or Intervention thumb image.
	 * @return bool
	 */
	protected function saveThumb()
	{
		$img = Image::make(base_path() . '/storage/app/public/uploads/' . $this->filename);
		$thumb_width = $this->config->get('thumb_width');
		$thumb_height = $this->config->get('thumb_height');
		$quality = $this->config->get('image_quality');
		$img->fit($thumb_width, $thumb_height);
		if ($this->checkPath(base_path() . '/storage/app/public/uploads/' . $this->template . '/thumb')) {
			if ($img->save(base_path() . '/storage/app/public/uploads/' . $this->template . '/thumb/' . $this->filename, $quality)) {
				return $img;
			} else {
				return false;
			}
		}
		return false;
	}

	/**
	 * Creating and saving template formats
	 * @return bool
	 */
	protected function saveTemplate()
	{
		$errors = false;
		$defaults_filter = ['preview', 'thumb'];
		$img = Image::make(base_path() . '/storage/app/public/uploads/' . $this->filename);
		$image_format = new ImageFormat;
		$formats = $image_format->selectByTemplate($this->template);
		foreach ($formats as $format) {
			if (!in_array($format->name, $defaults_filter)) {
				$default_width = $format->width;
				$default_height = $format->height;
				$quality = $this->config->get('image_quality');
				$img->fit($default_width, $default_height);
				if ($this->checkPath(base_path() . '/storage/app/public/uploads/' . $this->template . '/' . $format->name)) {
					if ($img->save(base_path() . '/storage/app/public/uploads/' . $this->template . '/' . $format->name . '/' . $this->filename, $quality)) {
                        //
					} else {
						$errors = true;
					}
				}
			}
		}
		return $errors ? false : true;
	}

	/**
	 * Format to MB's
	 * @param $bytes
	 * @param int $precision
	 * @return string
	 */
	public function formatBytes($bytes, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
		$bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

		return round($bytes, $precision) . ' ' . $units[$pow];
	}

	/**
	 * Check if path exists. If not make it.
	 * @param $path
	 * @return bool
	 */
	protected function checkPath($path)
	{
		if (!File::exists($path)) {
			if (File::makeDirectory($path, 0775, true)) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}


}