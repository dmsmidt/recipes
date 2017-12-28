<?php namespace App\Admin\Repositories\Contracts;

interface ILanguageRepository{

    public function selectTree();

    public function SelectById($id);

    public function add($input);

    public function update($input, $id);

    public function delete($id);

    public function defaultLanguage();

    public function userLanguage($user);

    public function activeLanguages();
}