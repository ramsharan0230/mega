<?php

namespace App\Repositories\Country;

use App\Repositories\Crud\CrudInterface;

interface CountryInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
