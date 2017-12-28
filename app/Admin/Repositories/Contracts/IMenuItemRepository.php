<?php namespace App\Admin\Repositories\Contracts;

interface IMenuItemRepository{

    public function selectTree($parent_id);

    public function SelectById($id);

    public function add($input, $parent_id);

    public function update($input, $id);

    public function delete($parent_id, $id);
}