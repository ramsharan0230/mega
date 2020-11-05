<?php

namespace App\Repositories\Subscriber;

use App\Models\Subscriber;
use App\Repositories\Crud\CrudRepository;

class SubscriberRepository extends CrudRepository implements SubscriberInterface
{
	public function __construct(Subscriber $subscriber)
	{
		$this->model = $subscriber;
	}
	public function create($input)
	{
		$this->model->create($input);
	}
	public function update($input, $id)
	{
		$this->model->find($id)->update($input);
	}
}
