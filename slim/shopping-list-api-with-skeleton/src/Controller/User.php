<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Entity\User;

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

    public function createUser(Request $request, Response $response, $args)
    {

        $data = $request->getParsedBody();

        $username=  filter_var($data['username'], FILTER_SANITIZE_STRING);
        $password=  filter_var($data['password'], FILTER_SANITIZE_STRING);
        $email=  filter_var($data['email'], FILTER_SANITIZE_STRING);

        $user = new User($username, $password, $email, new \DateTime("now"));

        $this->userResource->save($user);

        return $response->withJson($user);
    }
}
