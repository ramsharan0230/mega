<?php

namespace App\Repositories\DateTime;

use App\Repositories\Crud\CrudInterface;

interface DateTimeInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
