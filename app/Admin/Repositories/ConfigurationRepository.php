<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IConfigurationRepository;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;

class ConfigurationRepository extends BaseRepository implements IConfigurationRepository{

    public function selectTree(){
        return Configuration::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return Configuration::find($id);
    }

    public function add($input){
        $model = new Configuration;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Configuration::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Configuration::find($id);
        $model->delete();
        
    }

    public function selectSettings(){
        $r = DB::select(DB::raw("SELECT configurations.name,
                                               configurations.label,
                                               configurations.value_type,
                                               settings.string,
                                               settings.text,
                                               settings.boolean,
                                               settings.integer,
                                               settings.float,
                                               settings.datetime,
                                               settings.timestamp
                                        FROM configurations
                                        LEFT JOIN settings ON configurations.id = settings.configuration_id WHERE active = 1 AND is_header IS NULL; "));
        $settings = [];
        foreach($r as $key => $val){
            $settings[$r[$key]->name] = $val;
        }
        return $settings;
    }

    public function selectByName($name){
        $r = DB::select(DB::raw("SELECT configurations.name,
                                           configurations.label,
                                           configurations.value_type,
                                           settings.string,
                                           settings.text,
                                           settings.boolean,
                                           settings.integer,
                                           settings.float,
                                           settings.datetime,
                                           settings.timestamp
                                    FROM configurations
                                    LEFT JOIN settings ON configurations.id = settings.configuration_id WHERE name = ".$name))->first();
        return $r;
    }

}