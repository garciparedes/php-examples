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
$app->get('/items', 'App\Controller\Item:getItems')->setName('itemspage');
