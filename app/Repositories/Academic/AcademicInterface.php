<?php

namespace App\Repositories\Academic;

use App\Repositories\Crud\CrudInterface;

interface AcademicInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
