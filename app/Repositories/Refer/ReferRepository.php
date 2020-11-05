<?php

namespace App\Repositories\Refer;

use App\Models\Refer;
use App\Repositories\Crud\CrudRepository;

class ReferRepository extends CrudRepository implements ReferInterface
{
	public function __construct(Refer $model)
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
