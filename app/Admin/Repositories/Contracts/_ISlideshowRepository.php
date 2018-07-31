<?php namespace App\Admin\Repositories\Contracts;

interface ISlideshowRepository{

    public function selectAll();

    public function SelectById($id);

    public function add($input);

    public function update($input, $id);

    public function delete($id);

}