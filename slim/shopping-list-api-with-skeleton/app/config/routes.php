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


// Register routes
$app->group('/v1', function() {

    // Register auth routes
    $this->group('', function() {

        // Register with item routes
        $this->group('/items', function() {
            $this->get('', 'App\Controller\Item:getItems');
            $this->get('/{id}', 'App\Controller\Item:getItemById');
            $this->post('', 'App\Controller\Item:createItem');
            $this->patch('/{id}', 'App\Controller\Item:updateItemProperties');
            $this->delete('/{id}', 'App\Controller\Item:removeItem');
        });

        // Register product routes
        $this->group('/products', function() {
            $this->get('', 'App\Controller\Product:getProducts');
            $this->get('/{id}', 'App\Controller\Product:getProductById');
            $this->post('', 'App\Controller\Product:createProduct');
        });

        // Register user routes
        $this->group('/users', function() {
            $this->get('', 'App\Controller\User:getUsers');
            $this->get('/{username}', 'App\Controller\User:getUser');
        });

    })->add(new \App\Middleware\BasicAuthentication(
            (new \App\Resource\UserResource($this->getContainer()->get('database')))->getAsArray()
    ));

    // Register without auth routes
    $this->group('', function() {

        // Register user routes
        $this->group('/users', function() {
            $this->post('', 'App\Controller\User:createUser');
        });
    });
});
