<?php

class SearchReplaceDatabase
{
    protected $db, $host, $username, $password, $database;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function

    /**
     * Return db instance
     * @return mixed
     */
    public function db()
    {
        return $this->db;
    }
}