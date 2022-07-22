<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once 'Autoloader.php';
use Db\Db;
use Routes\Route;
$db = new Db();
Route::get('/controlsystem/users', 'getUsers');
Route::post('/controlsystem/addUser', 'addUser');
Route::get('/controlsystem/removeUser', 'removeUser');
Route::post('/controlsystem/updateUser', 'updateUser');
Route::post('/controlsystem/setstatus', 'setUsersStatuses');
try {

    Route::handleRequest($_SERVER['REQUEST_METHOD'], parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}
catch (Exception $e) {
    echo $e->getMessage();
}

