<?php

namespace App\Repositories\Message;

use App\Models\Message;
use App\Repositories\Crud\CrudRepository;

class MessageRepository extends CrudRepository implements MessageInterface
{
	public function __construct(Message $model)
	{
		$this->model = $model;
	}
	public function create($data)
	{
		$detail = $this->model->create($data);
		return $detail;
	}
	public function update($data, $id)
	{
		return $this->model->find($id)->update($data);
	}
}
