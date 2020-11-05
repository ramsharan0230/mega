<?php

namespace App\Repositories\Scholarship;

use App\Models\Scholarship;
use App\Repositories\Crud\CrudRepository;

class ScholarshipRepository extends CrudRepository implements ScholarshipInterface
{
	public function __construct(Scholarship $model)
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
			'title' => 'required',
			'type' => 'required',
			'percent' => 'sometimes|nullable|between:0,100|numeric',
			'image' => 'image|max:3048',
			'logo' => 'max:3048',
		];
	}
}
