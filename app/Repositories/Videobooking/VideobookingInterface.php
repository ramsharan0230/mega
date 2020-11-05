<?php

namespace App\Repositories\Videobooking;

use App\Repositories\Crud\CrudInterface;

interface VideobookingInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
