<?php

namespace App\Repositories\Subscriber;

use App\Repositories\Crud\CrudInterface;

interface SubscriberInterface extends CrudInterface
{
	public function create($input);
	public function update($data, $id);
}
