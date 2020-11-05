<?php

namespace App\Repositories\User;

use App\User;
use App\Repositories\Crud\CrudRepository;

class UserRepository extends CrudRepository implements UserInterface
{
	public function __construct(User $user)
	{
		$this->model = $user;
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
