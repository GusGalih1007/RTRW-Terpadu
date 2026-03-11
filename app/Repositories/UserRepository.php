<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Users;
use Illuminate\Support\Facades\Crypt;

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

    public function getByRtrw(string $rtrw)
    {
        return $this->model->where('rtRwId', $rtrw)->get();
    }

    public function getByKelurahan($kodeKelurahan)
    {
        return $this->model->where('kodeKelurahan', $kodeKelurahan)->get();
    }

    public function store(array $data)
    {
        $data['password'] = Crypt::encrypt($data['password']);

        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $model = $this->getById($id);

        if (isset($data['password'])) {
            $data['password'] = Crypt::encrypt($data['password']);
        }

        $model->update($data);

        return $model->fresh();
    }

    public function delete(string $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
