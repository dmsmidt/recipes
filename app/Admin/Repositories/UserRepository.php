<?php namespace App\Admin\Repositories;

use App\Admin\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class UserRepository extends BaseRepository implements IUserRepository{

    public function selectAll(){
        $current_role = Session::get('user.role_id');
        return User::where('role_id','>=', $current_role)->get()->toArray();
    }

    public function SelectById($id){
        return User::find($id);
    }

    public function add($input){
        $input['password'] = Hash::make($input['password']);
        $model = new User;
        $model->fill($input)->save();
        
    }

    public function update($input, $id){
        if(isset($input['password'])){$input['password'] = Hash::make($input['password']);}
        $model = User::find($id);
        $model->fill($input)->save();
    }

    public function delete($id){
        $model = User::find($id);
        $model->delete();
    }
}