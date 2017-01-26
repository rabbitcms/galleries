<?php
declare(strict_types=1);
use Illuminate\Routing\Router;

/* @var Router $router */
$router->group(['prefix' => 'galleries', 'as' => 'galleries.'], function (Router $router) {
    $router->get('', ['as' => 'index', 'uses' => 'GalleriesController@getIndex']);
    $router->post('', ['as' => 'list', 'uses' => 'GalleriesController@postIndex']);

    $router->get('create', ['as' => 'create', 'uses' => 'GalleriesController@getCreate']);
    $router->post('create', ['as' => 'store', 'uses' => 'GalleriesController@postCreate']);

    $router->get('edit/{id}', ['as' => 'edit', 'uses' => 'GalleriesController@getEdit']);
    $router->post('edit/{id}', ['as' => 'update', 'uses' => 'GalleriesController@postEdit']);

    $router->post('delete/{id}', ['as' => 'delete', 'uses' => 'GalleriesController@postDelete']);

    $router->post('file-upload/{id}', ['as' => 'file.upload', 'uses' => 'GalleriesController@postUploadFile']);
    $router->post('file-delete/{id}', ['as' => 'file.delete', 'uses' => 'GalleriesController@postDeleteFile']);
});
