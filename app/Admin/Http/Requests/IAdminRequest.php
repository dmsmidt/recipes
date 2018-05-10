<?php namespace App\Admin\Http\Requests;


interface IAdminRequest {

    public function recipe();

    public function module();

    public function action();

    public function route();

    public function segments();

    public function path();

    public function hasChilds();

    public function parent_id();

    public function formAction();

    public function childModule();

    public function moduleItemId();

}