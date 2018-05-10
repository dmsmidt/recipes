<?php namespace App\Admin\Repositories\Contracts;

interface _IMenuItemRepository{

    public function selectTree($parent_id = null);

    public function SelectById($parent_id, $id);

    public function add($input);

    public function update($input, $id);

    public function delete($parent_id, $id);
}