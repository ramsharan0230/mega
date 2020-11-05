<?php

namespace App\Repositories\Branch;

use App\Repositories\Crud\CrudInterface;

interface BranchInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
