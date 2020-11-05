<?php

namespace App\Repositories\Visitor;

use App\Repositories\Crud\CrudInterface;

interface VisitorInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
