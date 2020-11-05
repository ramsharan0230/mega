<?php

namespace App\Repositories\Academic;

use App\Models\Academic;
use App\Repositories\Crud\CrudRepository;

class AcademicRepository extends CrudRepository implements AcademicInterface
{
	public function __construct(Academic $model)
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
}
