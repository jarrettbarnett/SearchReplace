<?php namespace SearchReplaceTest;

use PHPUnit\Framework\TestCase;
use SearchReplace\SearchReplace;
use SearchReplace\SearchReplaceDatabase;
use SearchReplace\SearchReplaceException;
use \Mockery;

class SearchReplaceTest extends TestCase
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

    /** @test */
    public function search() {}

    /** @test */
    public function replace() {}

    /** @test */
    public function set_database_manually()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setDatabase(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);

        $this->assertTrue(is_object($searchReplace->db()), 'Manual database connection failed.');
    }

    /** @test */
    public function set_bad_database_credentials_throws_exception()
    {
        try {
            $searchReplace = new SearchReplace();
            $searchReplace->setDatabase('localhost', 'bad_user', 'bad_pass', 'bad_database');
        } catch (\Exception $e)
        {
            $exception = $e;
        }
        
        $this->assertObjectHasAttribute('serializableTrace', $exception, 'Exception not thrown for bad database credentials!');
    }

    /** @test */
    public function set_database_using_resource_object()
    {
        $database = new \mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
        $searchReplace = new SearchReplace($database);
        $db = $searchReplace->db();

        $this->assertInstanceOf(\mysqli::class, $db);
    }

    /** @test */
    public function throws_exception_when_something_goes_wrong()
    {
        try {
            $searchReplace = new SearchReplace();
            $searchReplace->throwError('First Error Message');
        } catch (SearchReplaceException $e) {
            $message = $e->getMessage();
        }

        $this->assertNotEmpty($message, 'Error message should not be empty!');
        $this->assertEquals('First Error Message', $message, 'Wrong kind of exception thrown!');
        
        try {
            $searchReplace->enableExceptions();
            $searchReplace->throwError('Second Error Message');
        } catch (SearchReplaceException $e) {
            $message = $e->getMessage();
        }

        $this->assertNotEmpty($message, 'Error message should not be empty!');
        $this->assertEquals('Second Error Message', $message, 'Wrong kind of exception thrown!');
    }

    /** @test */
    public function doesnt_throw_exception_when_something_goes_wrong_and_exceptions_disabled()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->disableExceptions();
        
        $error = $searchReplace->throwError('Second Error Message');
        $this->assertEquals(false, $error, 'Expecting a boolean of false!');

        $another_error = $searchReplace->throwError('Third Error Message', 'Custom Value If Exceptions Disabled');
        $this->assertEquals('Custom Value If Exceptions Disabled', $another_error, 'Custom value not being returned when exceptions are disabled!');
    }

    /** @test */
    public function get_exception_string()
    {
        try {
            $searchReplace = new SearchReplace();
            $searchReplace->throwError('Some Error Message');
        } catch (SearchReplaceException $e) {
            $exception = $e;
        }

        ob_start();
        echo $exception;
        $message = ob_get_clean();

        $this->assertEquals('SearchReplace\SearchReplaceException: [0]: Some Error Message', trim($message));
    }
    
    /** @test */
    public function can_set_and_get_table_offset()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableOffset(100);
        $offset = $searchReplace->getTableOffset();
        
        $this->assertEquals(100, $offset);
    }
    
    /** @test */
    public function can_set_and_get_table_limit()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableLimit(100);
        $offset = $searchReplace->getTableLimit();
        
        $this->assertEquals(100, $offset);
    }
    
    /** @test */
    public function can_set_and_get_range_values()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableRange(30, 10);
        $offset = $searchReplace->getTableOffset();
        $limit = $searchReplace->getTableLimit();
        
        $this->assertEquals(30, $offset);
        $this->assertEquals(10, $limit);
    }
    
    /** @test */
    public function can_set_and_get_table_row_offset()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableRowOffset(100);
        $offset = $searchReplace->getTableRowOffset();
        
        $this->assertEquals(100, $offset);
    }
    
    /** @test */
    public function can_set_and_get_table_row_limit()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableRowLimit(100);
        $offset = $searchReplace->getTableRowLimit();
        
        $this->assertEquals(100, $offset);
    }
    
    /** @test */
    public function can_set_and_get_row_range_values()
    {
        $searchReplace = new SearchReplace();
        $searchReplace->setTableRowRange(30, 10);
        $offset = $searchReplace->getTableRowOffset();
        $limit = $searchReplace->getTableRowLimit();
        
        $this->assertEquals(30, $offset);
        $this->assertEquals(10, $limit);
    }

    public function verify_prereqs() {}

    public function reset() {}
}