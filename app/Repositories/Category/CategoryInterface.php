<?php

namespace App\Repositories\Category;

use App\Repositories\Crud\CrudInterface;

interface CategoryInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
