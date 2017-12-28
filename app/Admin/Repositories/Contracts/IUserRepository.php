<?php namespace App\Admin\Repositories\Contracts;

interface IUserRepository{

    public function selectAll();

    public function SelectById($id);

    public function add($input);

    public function update($input, $id);

    public function delete($id);
}