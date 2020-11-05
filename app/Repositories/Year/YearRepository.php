<?php

namespace App\Repositories\Year;

use App\Models\Year;
use App\Repositories\Crud\CrudRepository;

class YearRepository extends CrudRepository implements YearInterface
{
	public function __construct(Year $model)
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
