<?php

namespace App\Repositories\Message;

use App\Repositories\Crud\CrudInterface;

interface MessageInterface extends CrudInterface
{
	public function create($data);
	public function update($data, $id);
}
