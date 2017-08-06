[![Build Status](https://travis-ci.org/jarrettbarnett/SearchReplace.svg?branch=master)](https://travis-ci.org/jarrettbarnett/SearchReplace)
[![Coverage Status](https://coveralls.io/repos/github/jarrettbarnett/SearchReplace/badge.svg?branch=master)](https://coveralls.io/github/jarrettbarnett/SearchReplace?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jarrettbarnett/SearchReplace/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jarrettbarnett/SearchReplace/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6ddf9fd3-dd10-4fb2-81f2-47b28fba1734/mini.png)](https://insight.sensiolabs.com/projects/6ddf9fd3-dd10-4fb2-81f2-47b28fba1734)

# Search and Replace 

SearchReplace is a PHP library aimed at executing search and replace queries on the database and even handles json, serialized data, and base64 replacements.


## Basic Example
Without composer

    require 'src/SearchReplace.php';
    
    $request = new SearchReplace();
    $request->setDatabase($host, $username, $password, $database)
            ->search($needle, $search_regex)
            ->replace($needle, $search_regex)
            ->execute();
 
## Basic Example (Composer)
Using composer autoload

    // require autoloader
    require 'vendor/autoload.php';
    
    // use namespace
    use SearchReplace/SearchReplace;
    
    // .. somewhere in your file

    $request = new SearchReplace();
    $request->setDatabase()
            ->search($needle, $search_regex)
            ->replace($needle, $search_regex)
            ->execute();
        
## Advanced Example
Create a custom database resource that we can pass around. Specify tables to exclude during search execution.
    
    // create custom database connection
    $db_instance = new SearchReplaceMySQLDatabase($host, $username, $password, $database);
    $exclude_tables = [
        'craft_entries'
        'wp_posts',
        'wp_postmeta'
    ];
    
    $request = new SearchReplace();
    $request->setDatabase($db_instance)
            ->search($needle, $search_regex)
            ->replace($needle, $search_regex)
            ->includeAllTables(true)
            ->excludeTables($exclude_tables)
            ->setTableOffset(50)
            ->setTableLimit(10)
            ->execute();

## Methods

### setDatabase( _mixed_ $resource_or_host [, _string_ $username, _string_ $password, _string_ $database ] )
You can pass in a database resource or you can allow the class to create a new database resource by providing the full database credentials.
#### Parameters
###### $resource_or_host _(string)_ or _(resource)_
* Expects either a database resource or if you want the class to create a new connection, provide the host address as a string.

Database resource example:

    $mysqli = new mysqli('localhost', 'user', 'password', 'database');
    
    $request = new SearchReplace();
    $request->setDatabase($mysqli);
    
Database resource example shortened:

    $request = new SearchReplace(new mysqli('localhost', 'user', 'password', 'database'));
    
Credentials example:

    $request = new SearchReplace();
    $request->setDatabase('localhost', 'user', 'password', 'database');

###### $username _(string)_
* The username needed to connect to the database.
###### $password _(string)_
* The password needed to connect to the database.
###### $database _(string)_
* The name of the database.

### search( _string_ $needle, _bool_ regex )
Call this method to define a search on the database. This is also useful in performing dry runs.
#### Parameters
###### $needle _(string)_
* The value to find in the database
###### $regex _(bool)_
* Whether the search needle is a RegEx pattern

### replace( _string_ $replace, _bool_ $regex )
Call this method to define replacements on the database.
###### $replace _(string)_
* The value to replace the search needle with
###### $regex _(bool)_
* Whether the replace value is a RegEx pattern

### includeAllTables( _bool_ $bool = true)
Adds all tables to the search queue. Defaults to true.
#### Parameters
###### $bool _(boolean)_
* True - enables adding all tables to the search queue.
* False - disables adding all tables to the search queue.

### includeTables( _array_ $tables, _bool_ $override = false)
Allows you to specify what tables are in the search queue.
#### Parameters
###### $tables _(array)_
* An array containing the tables to perform the search on.

###### $override _(bool)_
* Whether to override any previously set include tables.

### excludeTables( _array_ $tables )
#### Parameters
###### $tables _(array)_
* An array containing the tables that should not be searched.

### reset()
Resets all table inclusions, exclusions, table ranges, and table row ranges

### resetTables()
Resets table inclusions and exclusions

### setTableOffset( _int_ $offset = 0)

### setTableLimit( _int_ $limit )
### setTableRange()
### setTableRowOffset()
### setTableRowLimit()
### setTableRange()
### verifyPrereqs()

### execute()
Executes the search and replacement.
