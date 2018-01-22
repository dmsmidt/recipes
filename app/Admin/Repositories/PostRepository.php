<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IPostRepository;
use App\Models\Post;

class PostRepository extends BaseRepository implements IPostRepository{

    public function selectTree(){
        return Post::all()->toHierarchy()->toArray();
    }

    public function SelectById($id){
        return Post::find($id);
    }

    public function add($input){
        $model = new Post;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        $model = Post::find($id);
        $model->fill($input)->save();
        
    }

    public function delete($id){
        $model = Post::find($id);
        $model->delete();
        
    }
}