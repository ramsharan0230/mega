<?php

namespace App\Repositories\DateTime;

use App\Models\Datetime;
use App\Repositories\Crud\CrudRepository;

class DateTimeRepository extends CrudRepository implements DateTimeInterface
{
	public function __construct(Datetime $model)
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
			'date' => 'required',
			'time' => 'required',
			'exhibitor_id' => 'required',
		];
	}
}
