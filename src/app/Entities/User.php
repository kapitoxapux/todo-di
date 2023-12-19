<?php

namespace App\Entities;

class User
{

    public int $id;
    public string $name;
    public string $password;
    public string $email;
    public string $role;

    function getId()
    {
        return $this->id;
    }

    function getName(): string
    {
        return $this->name;
    }

    function setName(int $name)
    {
        $this->name = $name;

        return $this;
    }

    function setPassword(string $password)
    {
        $this->password = md5($password);

        return $this;
    }

    function getEmail(): string
    {
        return $this->email;
    }

    function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    function getRole(): string
    {
        return $this->role;
    }

    function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

}
