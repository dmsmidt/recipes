<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ITestRepository;
use App\Models\Test;

class TestRepository extends BaseRepository implements ITestRepository{

    public function selectTree(){
        return Test::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return Test::find($id);
    }

    public function add($input){
        $model = new Test;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Test::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Test::find($id);
        $model->delete();
        
    }
}