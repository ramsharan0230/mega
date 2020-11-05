<?php

namespace App\Repositories\Branch;

use App\Models\Branch;
use App\Repositories\Crud\CrudRepository;

class BranchRepository extends CrudRepository implements BranchInterface
{
	public function __construct(Branch $model)
	{
		$this->model = $model;
	}
	public function create($data)
	{
		$detail = $this->model->create($data);
		return $detail;
	}
	public function update($data, $id)
	{
		return $this->model->find($id)->update($data);
	}

	public function rules()
	{
		return [
			'exhibitor_id' => 'required',
			'address' => 'required',
			'mobile' => 'nullable|digits:10',
		];
	}
}
