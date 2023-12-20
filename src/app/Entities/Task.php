<?php

namespace App\Entities;

class Task
{

    public int $id;
    public string $user_id;
    public string $text;
    public int $status;
    public int $changed;

    function getId(): int
    {
        return $this->id;
    }

    function getUserId(): string
    {
        return $this->user_id;
    }

    function setUserId(int $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    function getText(): string
    {
        return $this->text;
    }

    function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    function getStatus(): int
    {
        return $this->status;
    }

    function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    function getChanged(): int
    {
        return $this->changed;
    }

    function setChanged(int $changed)
    {
        $this->changed = $changed;

        return $this;
    }

}
