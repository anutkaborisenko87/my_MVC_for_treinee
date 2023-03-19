<?php

namespace OptimMVC\Core;

use OptimMVC\Core\DataBase\QueryBuilder;

class Auth
{
    protected $connection;
    protected $session;
    protected $user;

    public function __construct()
    {
        $this->connection = (new QueryBuilder())->table('users');
        $this->session = new Session();
        $this->user = null;
    }

    public function attempt($email, $password): bool
    {
        $user = $this->getUserByEmail($email);
        if (!$user) {
            return false;
        }
        if (password_verify($password, $user['password'])) {
            $this->session->set('user_id', $user['id']);
            $this->user = $user;
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        if (!$this->user && $this->session->has('user_id')) {
            $user_id = $this->session->get('user_id');
            $this->user = $this->getUserById($user_id);
        }
        return $this->user !== null;
    }

    public function user()
    {
        return $this->user;
    }

    public function logout()
    {
        $this->session->remove('user_id');
        $this->user = null;
    }

    protected function getUserByEmail($email)
    {
        return $this->connection->where('email', '=', $email)->first();
    }

    protected function getUserById($id)
    {
        return $this->connection->where('id', '=', $id)->first();
    }
}
