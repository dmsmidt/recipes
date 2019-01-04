<?php namespace App\Admin\Http\Controllers;

use App\Admin\Http\Requests\ConfigurationRequest;
use App\Admin\Repositories\Contracts\IConfigurationRepository;

class ConfigurationController extends AdminController
{

	protected $configuration;

	public function __construct(IConfigurationRepository $configuration)
	{
		$this->configuration = $configuration;
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = $this->configuration->selectTree();
		return view('admin')
			->with("javascripts", ["/cms/js/jquery.nestable.js"])
			->nest('center', 'main.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin')->nest('center', 'main.form');
	}

	/**
	 * @param ConfigurationRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(ConfigurationRequest $request)
	{
		$this->configuration->add($request->input());
		return redirect('admin/configurations');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data = $this->configuration->selectById($id);
		return view('admin')->nest('center', 'main.form', compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 * @param RoleRequest $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(ConfigurationRequest $request, $id)
	{
		$this->configuration->update($request->input(), $id);
		return redirect('admin/configurations');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->configuration->delete($id);
		return redirect()->back();
	}

}