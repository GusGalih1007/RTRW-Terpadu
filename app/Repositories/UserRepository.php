<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Users;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct(Users $user)
    {
        $this->model = $user;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function getById(string $id) 
    {
        return $this->model->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $model = $this->getById($id);

        $model->update($data);

        return $model->fresh();
    }

    public function delete(string $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
