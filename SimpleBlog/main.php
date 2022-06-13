<?php

require_once 'Autoloader.php';
use Routes\Route;


Route::post('/simpleblog/addPost', 'addPost');
Route::get('/simpleblog/posts', 'getPosts');
Route::post('/simpleblog/addComment', 'addComment');
Route::post('/simpleblog/addRate', 'addRate');
try {

    Route::handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}
catch (Exception $e) {
    echo $e->getMessage();
}



