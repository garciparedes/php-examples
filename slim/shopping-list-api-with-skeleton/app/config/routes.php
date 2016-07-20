<?php
/**
 * This file is part of `oanhnn/slim-skeleton` project.
 *
 * (c) Oanh Nguyen <oanhnn.bk@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

// Register middleware
$app->add(new \Slim\HttpCache\Cache('public', 86400));

// Register example routes
//$app->get('/items', 'App\Controller\Item:getItems')->setName('itemspage');
//$app->get('/items/{id}', 'App\Controller\Item:getItemById')->setName('itemspage');
//$app->post('/items', 'App\Controller\Item:createItem')->setName('itemspage');
//$app->put('/items/{id}', 'App\Controller\Item:updateItem')->setName('itemspage');
//$app->delete('/items/{id}', 'App\Controller\Item:removeItem')->setName('itemspage');

$app->group('/v1', function() {
    $this->group('/items', function() {
        $this->get('', 'App\Controller\Item:getItems');
        $this->get('/{id}', 'App\Controller\Item:getItemById');
        $this->post('', 'App\Controller\Item:createItem');
        $this->put('/{id}', 'App\Controller\Item:updateItem');
        $this->delete('/{id}', 'App\Controller\Item:removeItem');
    });
    $this->group('/products', function() {
        $this->get('', 'App\Controller\Product:getProducts');
    });

});
