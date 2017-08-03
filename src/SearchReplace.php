<?php namespace SearchReplace;

use SearchReplace\SearchReplaceDatabase;
use SearchReplace\DatabaseTypes\MySQLi;

/**
 * Class SearchReplace
 * @package SearchReplace
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Jarrett Barnett <hello@jarrettbarnett.com>
 */
class SearchReplace
{
    /**
     * Collection of tables to execute search on
     * @var (array) $tables
     */
    protected $tables;
    protected $tables_include;
    protected $tables_exclude;

    protected $tables_include_all = false;
    protected $table_offset;
    protected $table_limit;
    protected $table_row_offset;
    protected $table_row_limit;

    /**
     * @var bool $exceptions - enable/disable exceptions
     */
    protected $exceptions = true;
    protected $errors;

    /**
     * SearchReplace constructor.
     * @param $db_resource
     */
    public function __construct($db_resource = '')
    {
        if (!empty($db_resource))
        {
            $this->setDatabase($db_resource);
        }
    }

    /**
     * Search
     *
     * @param $search
     * @param bool $regex
     */
    public function search($search, $regex = false)
    {

    }

    /**
     * Replace
     *
     * @param $replace
     * @param bool $regex
     */
    public function replace($replace, $regex = false)
    {

    }

    /**
     * Set Database
     * @param $resource_or_host
     * @param $username
     * @param $password
     * @param $database
     * @return $this
     */
    public function setDatabase($resource_or_host = '', $username = '', $password = '', $database = '')
    {
        if (empty($resource_or_host)) return $this->throwError('setDatabase(): Database resource/hostname cannot be empty');

        if (is_resource($resource_or_host)) {
            $this->db = $resource_or_host;

            return $this;
        }

        if (empty($username)) return $this->throwError('setDatabase(): Username parameter cannot be empty.');
        if (empty($database)) return $this->throwError('setDatabase(): Database name parameter cannot be empty.');

        // empty passwords are allowed
        $password = (empty($password)) ? '' : $password;

        $instance = new SearchReplaceDatabase($resource_or_host, $username, $password, $database);
        $this->db = $instance->db();

        return $this;
    }

    /**
     * Throw Error
     * @param $error_message
     * @param bool $return_value_if_disabled
     * @return bool
     */
    public function throwError($error_message, $return_value_if_disabled = false)
    {
        if ($this->exceptions)
        {
            throw new Exception($error_message);
        }

        return $return_value_if_disabled;
    }

    /**
     * Include All Tables
     * @param $bool (bool)
     * @return $this
     */
    public function includeAllTables($bool)
    {
        if (!is_bool($bool)) return $this->throwError('includeAllTables(): Non-boolean value supplied.');

        $this->include_all_tables = $bool;

        return $this;
    }

    /**
     * Include Tables
     * @param $tables
     * @param bool $override
     * @return $this
     */
    public function includeTables($tables, $override = false)
    {
        if ($override) {
            $this->tables_include = $tables;

            return $this;
        }

        $this->tables = array_merge($this->tables, $tables);

        return $this;
    }

    /**
     * Exclude Tables
     * @param $tables
     * @return $this
     */
    public function excludeTables($tables, $override = false)
    {
        if ($override) {
            $this->tables_exclude = $tables;

            return $this;
        }
        $this->tables_exclude = array_merge($this->tables, $tables);

        return $this;
    }

    /**
     * Reset Tables (Inclusions and Exclusions)
     * @return $this
     */
    public function resetTables()
    {
        $this->tables_include = [];
        $this->tables_exclude = [];

        return $this;
    }

    /**
     * Start table execution at a specific offset
     * Useful for executing search in batches
     * @param $offset
     * @return $this
     */
    public function setTableOffset($offset)
    {
        if (!is_numeric($offset)) return $this->throwError('Table offset must be a number!');

        $this->table_offset = (int) $offset;

        return $this;
    }

    /**
     * Set limit on table list
     * @param $limit
     * @return $this
     */
    public function setTableLimit($limit)
    {
        if (!is_numeric($limit)) return $this->throwError('Table limit must be a number!');

        $this->table_limit = (int) $limit;

        return $this;
    }

    /**
     * Set offset and limit on table list
     * @param $offset
     * @param $limit
     * @return $this
     */
    public function setTableRange($offset, $limit)
    {
        $this->setTableOffset($offset);
        $this->setTableLimit($limit);

        return $this;
    }

    /**
     * Start row search/replace at a specific row offset
     * Useful for executing search/replacements on a specific table in batches
     * @param $offset
     * @return $this
     */
    public function setTableRowOffset($offset)
    {
        $this->table_row_offset = (int) $offset;

        return $this;
    }

    /**
     * Limit how many rows are executed per table
     * Useful for executing search/replacements on a specific table in batches
     * @param $limit
     * @return $this
     */
    public function setTableRowLimit($limit)
    {
        $this->table_row_limit = (int) $limit;

        return $this;
    }

    /**
     * Set table row range (limit and offset)
     * @param $offset
     * @param $limit
     * @return $this
     */
    public function setTableRowRange($offset, $limit)
    {
        $this->setTableRowOffset($offset);
        $this->setTableRowLimit($limit);

        return $this;
    }

    /**
     * Verify Prerequisites
     *
     * @return array
     */
    public function verifyPrereqs()
    {
        if (empty($this->db))
        {
            $this->errors[] = 'Database connection not provided.';
        }

        return $this->errors;
    }

    /**
     * Reset The Request For Another Go-Round'
     */
    public function reset()
    {
        $this->tables = [];
        $this->tables_include = [];
        $this->tables_exclude = [];
        $this->table_offset = [];
        $this->table_limit = [];
        $this->table_row_offset = [];
        $this->table_row_limit = [];
    }

    /**
     * Reset Errors
     * @return $this;
     */
    protected function resetErrors()
    {
        $this->errors = [];

        return $this;
    }

    /**
     * Append Error
     * @param $error
     * @return $this;
     */
    protected function appendError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * Prepare
     */
    private function prepare()
    {
        $this->prepareTables();
    }

    /**
     * Prepare Tables
     */
    private function prepareTables()
    {

    }

    /**
     * Execute!
     */
    public function execute()
    {
        $this->verifyPrereqs();
        $this->prepare();
    }
}