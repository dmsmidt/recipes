<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ISettingRepository;
use App\Models\Setting;
use App\Models\Configuration;
use App\Models\Language;
use Session;


class SettingRepository extends BaseRepository implements ISettingRepository{

    public function selectTree(){
        $role_id = Session::get('user.role_id');
        $configurations = Configuration::all()->toHierarchy()->toArray();
        foreach($configurations as $key => $config){
            if(!$config['active']){
                unset($configurations[$key]);
            }else{
                if(($config['protect'] && $role_id != 1) && !$config['is_header']){
                    unset($configurations[$key]);
                }else{
                    $settings = Setting::where('configuration_id',$config['id'])->first();
                    $configurations[$key]['value'] = $settings[$config['value_type']];
                }
            }
        }
        return $configurations;
    }

    public function SelectById($id){
        $configuration = Configuration::find($id);
        $settings = Setting::where('configuration_id',$id)->first();
        $configuration['value'] = $settings[$configuration['value_type']];
        return $configuration;
    }

    public function add($input){
        $model = new Setting;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        //dd($input);
        $setting = Setting::where('configuration_id',$id)->first();
        if(!$setting){
            $setting = new Setting;
            $setting->configuration_id = $id;
        }
        $setting->{$input['value_type']} = isset($input[$input['name']]) ? $input[$input['name']] : null;
        $setting->save();

        /**
         * The setting is a language setting if the name corresponds to a language abbrevication from the language table.
         * If so the active field of the language table has to be updated along with the language setting.
         */
        $languages = Language::all();
        foreach($languages as $language){
            if($language->abbr === $input['name']){
                $language->active = isset($input[$input['name']]) ? $input[$input['name']] : 0;
                $language->save();
                $repo = '\\App\\Admin\\Repositories\\LanguageRepository';
                $language_repo = new $repo();
                Session::put('language.active',$language_repo->activeLanguages());
            }
        }


    }

    public function delete($id){
        $model = Setting::find($id);
        $model->delete();
        
    }
}