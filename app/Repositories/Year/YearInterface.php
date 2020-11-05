<?php

namespace App\Repositories\Year;

use App\Repositories\Crud\CrudInterface;

interface YearInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
