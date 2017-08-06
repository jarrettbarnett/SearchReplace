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
    const DB_PASS = '';
    const DB_NAME = 'searchreplace_dev';

    public function setUp()
    {
        $this->db = new SearchReplaceDatabase(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
    }

    public function include_all_tables()
    {
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->includeAllTables(true);
    }

    /** @test */
    public function include_all_tables_empty_param_throws_exception()
    {
        try {
            $searchReplace = new SearchReplace($this->db);
            $searchReplace->enableExceptions();
            $searchReplace->includeAllTables('true');
        } catch (\Exception $e)
        {
            $message = $e->getMessage();
        }

        $this->assertNotEmpty($message, 'Exception message should not be empty');
    }

    /** @test */
    public function include_tables_adds_tables()
    {
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->includeTables(['table1', 'table2']);
        $this->assertContains('table1', $searchReplace->getTableIncludes(), 'Includes table array not merging!');
    }

    /** @test */
    public function include_tables_adds_and_resets_tables()
    {
        // first add the first set of tables
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->includeTables(['table1', 'table2']);
        $this->assertContains('table1', $searchReplace->getTableIncludes(), 'Includes table array not merging!');

        // now add a new set, resetting the previous set
        $searchReplace->includeTables(['table3', 'table4'], true);
        $this->assertNotContains('table1', $searchReplace->getTableIncludes(), 'Includes Table override not resetting the table includes!');
        $this->assertContains('table3', $searchReplace->getTableIncludes(), 'Includes table not setting new parameters after reset');
    }

    /** @test */
    public function exclude_tables()
    {
        // first add the first set of tables
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->excludeTables(['table2']);
        $this->assertContains('table2', $searchReplace->getTableExcludes());

        // now add a new set, resetting the previous set
        $searchReplace->excludeTables(['table3', 'table4'], true);
        $this->assertNotContains('table2', $searchReplace->getTableExcludes(), 'Excludes Table override not resetting the table includes!');
        $this->assertContains('table3', $searchReplace->getTableExcludes(), 'Excluding tables does not add the new parameters after resetting the data.');
    }

    /** @test */
    public function reset_tables()
    {
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->includeTables(['table1', 'table2']);
        $searchReplace->excludeTables(['table3', 'table4']);

        $this->assertContains('table1', $searchReplace->getTableIncludes());
        $this->assertContains('table3', $searchReplace->getTableExcludes());

        $searchReplace->resetTables();
        $this->assertEmpty($searchReplace->getTableIncludes(), 'Table includes did not reset!');
        $this->assertEmpty($searchReplace->getTableExcludes(), 'Table excludes did not reset!');
    }

    public function set_table_offset() {}

    public function set_table_limit() {}

    public function set_table_range() {}

    public function set_table_row_offset() {}

    public function set_table_row_limit() {}

    public function set_table_row_range() {}

    public function verify_prereqs() {}

    public function reset() {}

    public function execute()
    {
        $searchReplace = new SearchReplace($this->db);
        $searchReplace->execute();

        // TODO verify execution
    }
}