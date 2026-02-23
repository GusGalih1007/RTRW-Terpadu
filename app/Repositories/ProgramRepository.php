<?php

namespace App\Repositories;

use App\Interfaces\ProgramRepositoryInterface;
use App\Models\Program;
use Exception;

class ProgramRepository implements ProgramRepositoryInterface
{
    protected $model;
    /**
     * Create a new class instance.
     */
    public function __construct(Program $program)
    {
        $this->model = $program;
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
        try
        {
            return $this->model->create($data);
        } catch (Exception $e) {
            throw new Exception('Gagal menambah data ke dalam system: ' . $e->getMessage());
        }
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
        $data = $this->getById($id);

        if (!$data) {
            return false;
        }

        return true;
    }
}
