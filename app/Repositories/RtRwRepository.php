<?php

namespace App\Repositories;

use App\Interfaces\RtRwRepositoryInterface;
use App\Models\RtRw;
use Exception;

class RtRwRepository implements RtRwRepositoryInterface
{
    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct(RtRw $rtRw)
    {
        $this->model = $rtRw;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $model = $this->model->findOrFail($id);

        $model->update($data);

        return $model->fresh();
    }

    public function delete(string $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function dataExist(string $id)
    {
        $data = $this->model->findOrFail($id);

        if (!$data) {
            return false;
        }

        return true;
    }

    public function getByKelurahan(int $id)
    {
        return $this->model->where('kodeKelurahan', $id)->get();
    }
}
