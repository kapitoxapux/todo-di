<?php

namespace App\Entities;

class Task
{

    public int $id;
    public string $user_id;
    public string $text;
    public int $status;
    public int $changed;

    function getId()
    {
        return $this->id;
    }

    function getUserId()
    {
        return $this->user_id;
    }

    function setUserId(int $user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    function getText()
    {
        return $this->text;
    }

    function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    function getStatus()
    {
        return $this->status;
    }

    function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    function getChanged()
    {
        return $this->changed;
    }

    function setChanged(int $changed)
    {
        $this->changed = $changed;

        return $this;
    }

}
