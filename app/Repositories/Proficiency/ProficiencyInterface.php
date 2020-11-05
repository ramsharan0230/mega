<?php

namespace App\Repositories\Proficiency;

use App\Repositories\Crud\CrudInterface;

interface ProficiencyInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
