<?php namespace SearchReplace;

/**
 * Class SearchReplaceDatabase
 * @package SearchReplace
 * @author Jarrett Barnett <hello@jarrettbarnett.com>
 */
class SearchReplaceDatabase
{
    protected $db, $host, $username, $password, $database;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        return $this->db();
    }

    /**
     * Return db instance
     * @return mixed
     */
    public function db()
    {
        $this->db = new \mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->db->connect_errno) {
            throw new Exception("Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error);
        }

        return $this->db;
    }
}