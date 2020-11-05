<?php

namespace App\Repositories\Visitor;

use App\Models\Visitor;
use App\Repositories\Crud\CrudRepository;

class VisitorRepository extends CrudRepository implements VisitorInterface
{
	public function __construct(Visitor $model)
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
