<?php

namespace App\Interfaces;

interface RtRwRepositoryInterface
{
    public function getAll();
    public function getById(string $id);
    public function store(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
    public function dataExist(string $id);
    public function getByKelurahan(int $id);
}
