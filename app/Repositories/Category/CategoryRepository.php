<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Crud\CrudRepository;

class CategoryRepository extends CrudRepository implements CategoryInterface
{
	public function __construct(Category $model)
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
