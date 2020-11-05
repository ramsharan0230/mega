<?php

namespace App\Repositories\Refer;

use App\Repositories\Crud\CrudInterface;

interface ReferInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
