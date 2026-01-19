<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function loginPage();
    public function login(array $data);
    public function registerPage();
}
