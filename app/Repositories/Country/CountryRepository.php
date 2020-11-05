<?php

namespace App\Repositories\Country;

use App\Models\Country;
use App\Repositories\Crud\CrudRepository;

class CountryRepository extends CrudRepository implements CountryInterface
{
	public function __construct(Country $model)
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
