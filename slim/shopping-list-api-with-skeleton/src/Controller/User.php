<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class User extends Base
{

    public function getUsers(Request $request, Response $response, $args)
    {
        $users = $this->userResource->get();

        return $response->withJson($users);
    }

    public function getUser(Request $request, Response $response, $args)
    {
        $username = (string) $args['username'];

        $user = $this->userResource->getByUsername($username);

        return $response->withJson($user);
    }
}
