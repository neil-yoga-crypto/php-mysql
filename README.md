<snippet>
  <content>
# database-pdo-mysql-class-php
The only PDO MySQL class you need. Configured to support prepared and unprepared queries and to return the id of a newly created row if necessary. Creates the database if not exists.

## Installation
1. Extract PHP files in your www directory.
2. Install MySQL database server if not installed

## Usage
### Configure your database
```php
require('db.php');
Db::config('yourDatabasename','yourUsername','yourPassword');
```
### Select a table
```php
$sql = "SELECT * FROM yourTablename"; 
$results = Db::getDb()->query($sql);
foreach($results as $result)
{
    echo $result['yourColumnName'];
}
```
### Select a table with prepared statements
```php
$sql = "SELECT * FROM yourTablename WHERE id = :id";
$userInputValue = 'yourUnescapedValue';
$preparedStatements = array(':id'=>$userInputValue);
$results = Db::getDb()->query($sql,$preparedStatements);
foreach($results as $result)
{
    echo $result['yourColumnName'];
}
```
### Insert a table with prepared statements
```php
$sql = "INSERT INTO yourTablename(id,name) VALUES(:id,:name)";
$userInputId = 'yourUnescapedValue';
$userInputName = 'yourUnescapedValue';
$preparedStatements = array(':id'=>$userInputId,':name'=>$userInputName);
Db::getDb()->query($sql,$preparedStatements);
```
### Insert a table with prepared statements and get the id
```php
$sql = "INSERT INTO yourTablename(name) VALUES(:name)";
$userInputName = 'yourUnescapedValue';
$preparedStatements = array(':name'=>$userInputName);
$id = Db::getDb()->queryAndReturnId($sql,$preparedStatements);
```
## Contributing
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## License
database-pdo-mysql-class is licensed under The MIT License (MIT).
