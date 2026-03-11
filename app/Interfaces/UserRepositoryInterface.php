<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function getByRtrw(string $rtrw);
    public function getByKelurahan($kodeKelurahan);
    public function getById(string $id);
    public function store(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
}
