# Wordpress Search and Replace 

SearchReplace is a PHP library that makes it easier to perform data replacements on the database and even handles serialized data like that found in Wordpress, Drupal, and other often pre-json era applications.


 
## Basic Usage
$request = new SearchReplace();
$request->setDatabase($host, $username, $password, $database)
        ->search($needle, $search_regex)
        ->replace($needle, $search_regex)
        ->execute();

// get instance
// set database connection
// set needle and haystack
// set regex bool
// set tables to perform replacement on
// perform search/replace
// get results

## Methods

### setDatabase( _string_ $host, _string_ $username, _string_ $password, _string_ $database )
#### Parameters
###### $host _(string)_
* The host address for the database.

    e.g. 127.0.0.1, localhost, 192.168.100.1
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

### includeAllTables( _boolean_ $bool = true)
Adds all tables to the search queue. Defaults to true.
#### Parameters
###### $bool _(boolean)_
* True - enables adding all tables to the search queue.
* False - disables adding all tables to the search queue.

### includeTables( _array_ $tables )
Allows you to specify what tables to perform the search and replacement on.
#### Parameters
###### $tables _(array)_
* An array containing the tables to perform the search on.

### excludeTables( _array_ $tables )
#### Parameters
###### $tables _(array)_
* An array containing the tables that should not be searched.

### execute()
Executes the search and replacement.