<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IDashboardRepository;
use App\Models\Dashboard;

class DashboardRepository extends BaseRepository implements IDashboardRepository{

    public function selectAll(){
        return Dashboard::all()->toArray();
    }

    public function SelectById($id){
        return Dashboard::find($id);
    }

    public function add($input){
        $model = new Dashboard;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Dashboard::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Dashboard::find($id);
        $model->delete();
        
    }
}