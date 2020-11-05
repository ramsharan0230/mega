<?php

namespace App\Repositories\Exhibitor;

use App\Repositories\Crud\CrudInterface;

interface ExhibitorInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
