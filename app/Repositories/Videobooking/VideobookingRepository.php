<?php

namespace App\Repositories\Videobooking;

use App\Models\Videobook;
use App\Repositories\Crud\CrudRepository;

class VideobookingRepository extends CrudRepository implements VideobookingInterface
{
	public function __construct(Videobook $model)
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
