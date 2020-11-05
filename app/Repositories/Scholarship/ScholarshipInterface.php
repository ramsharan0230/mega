<?php

namespace App\Repositories\Scholarship;

use App\Repositories\Crud\CrudInterface;

interface ScholarshipInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
