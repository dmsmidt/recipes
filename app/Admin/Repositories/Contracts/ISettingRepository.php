<?php namespace App\Admin\Repositories\Contracts;

interface ISettingRepository{

    public function selectTree();

    public function SelectById($id);

    //public function add($input);

    public function update($input, $id);

    //public function delete($id);
}