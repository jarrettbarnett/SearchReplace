<?php namespace SearchReplaceTest;

use PHPUnit\Framework\TestCase;
use SearchReplace\SearchReplace;
use SearchReplace\SearchReplaceDatabase;
use SearchReplace\SearchReplaceException;

class SearchReplaceTablesTest extends TestCase
{
    protected $db;
    const DB_HOST = '127.0.0.1';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'searchreplace.dev';

    public function setUp()
    {
        $this->db = new SearchReplaceDatabase(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
    }

    public function include_all_tables() {}

    public function include_tables() {}

    public function exclude_tables() {}

    public function reset_tables() {}

    public function set_table_offset() {}

    public function set_table_limit() {}

    public function set_table_range() {}

    public function set_table_row_offset() {}

    public function set_table_row_limit() {}

    public function set_table_row_range() {}

    public function verify_prereqs() {}

    public function reset() {}
}