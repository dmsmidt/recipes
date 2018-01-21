<?php namespace App\Admin\Repositories\Contracts;

interface IMenuItemRepository {

    public function selectTree($parent_id = null);

    public function selectById($id);

    public function add($input,$parent_id);

    public function update($input, $id);

    public function delete($parent_id, $id);

}