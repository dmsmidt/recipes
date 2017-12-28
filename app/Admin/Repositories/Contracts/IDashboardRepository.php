<?php namespace App\Admin\Repositories\Contracts;

interface IDashboardRepository{

    public function selectAll();

    public function SelectById($id);

    public function add($input);

    public function update($input, $id);

    public function delete($id);
}