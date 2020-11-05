<?php

namespace App\Repositories\Proficiency;

use App\Models\Proficiency;
use App\Repositories\Crud\CrudRepository;

class ProficiencyRepository extends CrudRepository implements ProficiencyInterface
{
	public function __construct(Proficiency $model)
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
