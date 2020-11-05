<?php

namespace App\Repositories\Exhibitor;

use App\Models\Exhibitor;
use App\Repositories\Crud\CrudRepository;

class ExhibitorRepository extends CrudRepository implements ExhibitorInterface
{
	public function __construct(Exhibitor $model)
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

	public function store__country_exhibitor_table($id, $countries)
	{
		$detail = $this->model->find($id);
		foreach ($countries as $country) {
			$detail->countries()->attach($country);
		}
	}
	public function update__country_exhibitor_table($id, $countries)
	{
		$detail = $this->model->find($id);
		$detail->countries()->sync($countries);
	}
}
