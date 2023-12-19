<?php

namespace App\Repositories;

use App\Entities\Db;
use App\Entities\Task;
use App\Entities\User;

class TaskRepository
{

    private Db $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    private function checkUser(string $name, string $email): ?User
    {
        $sql = "SELECT id FROM users WHERE name=:name AND email=:email";
        $userData = $this->db->query(
            $sql,
            [
                ':name' => $name,
                ':email' => $email
            ],
            User::class
        );

        return !empty($userData) ? current($userData) : null;
    }

    private function addUser(string $name, string $email): void
    {
        $sql = "INSERT INTO users (name,email) VALUES (:name,:email)";
        $this->db->query(
            $sql,
            [
                ':name' => $name,
                ':email' => $email
            ],
            User::class
        );
    }

    private function addTask(int $userId, string $text): void
    {
        $sql = "INSERT INTO tasks (user_id,text) VALUES (:user_id,:text)";
        $this->db->query(
            $sql,
            [
                ':user_id' => $userId,
                ':text' => $text
            ],
            Task::class
        );
    }

    public function getById(int $id): ?Task
    {
        $res = $this->db->query(
            'SELECT * FROM tasks as t JOIN users as u ON t.user_id = u.id WHERE t.id=:id',
            [
                ':id' => $id
            ],
            Task::class
        );

        return !empty($res) ? $res[0] : null;
    }

    public function getAll(): int
    {
        $sql = "SELECT * FROM tasks";
        $res = $this->db->query(
            $sql,
            [],
            Task::class
        );

        return count($res);
    }

    public function getData(string $sort = 'name', string $order = 'ASC', int $limit = 3, int $offset = 0): ?array
    {
        $sql = "SELECT * FROM tasks as t INNER JOIN users as u ON t.user_id = u.id ORDER BY $sort $order LIMIT :offset, :limit";
        $res = $this->db->query(
            $sql,
            [
                ':offset' => $offset,
                ':limit' => $limit,
            ],
            Task::class
        );

        return !empty($res) ? $res : null;
    }

    public function setTask(string $name, string $email, string $text): void
    {
        $task = [];
        $userData = $this->checkUser($name, $email);
        if (is_null($userData)) {
            $this->addUser($name, $email);
            $userData = $this->checkUser($name, $email);
        }

        $this->addTask($userData->getId(), $text);
    }

    public function updateStatus(int $id): void
    {
        $sql = "UPDATE tasks SET status = 1 WHERE id = :id";
        $this->db->query(
            $sql,
            [
                ':id' => $id,
            ],
            Task::class
        );
    }

    public function changeTask(int $id, string $text): void
    {
        $sql = "UPDATE tasks SET text = :text, changed = 1 WHERE id = :id";
        $res = $this->db->query(
            $sql,
            [
                ':id' => $id,
                ':text' => $text
            ],
            Task::class
        );

    }

}
