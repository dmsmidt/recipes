<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\ITestItemRepository;
use App\Models\TestItem;

class TestItemRepository extends BaseRepository implements ITestItemRepository{

    public function selectTree(){
        return TestItem::all()->toHierarchy()->toArray();
    }

    public function SelectById($parent_id, $id){
        return TestItem::find($id);
    }

    public function add($input){
        $model = new TestItem;
        $model->fill($input)->save();
        $this->saveTranslations('test_items',$input, $model->id);
    }

    public function update($input, $id){
        $model = TestItem::find($id);
        $model->fill($input)->save();
        $this->saveTranslations('test_items',$input, $model->id);
    }

    public function delete($parent_id, $id){
        $model = TestItem::find($id);
        $model->delete();
        $this->deleteTranslations('test_items',$id);
    }

}