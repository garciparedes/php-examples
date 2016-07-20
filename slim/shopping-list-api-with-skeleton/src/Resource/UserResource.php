<?php

namespace App\Resource;

use Doctrine\ORM\EntityManager;
use App\Model\Entity\User;

class UserResource extends Base
{

    protected $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->userRepository = $this->entityManager->getRepository('\App\Model\Entity\User');

    }

    public function get(int $id = null)
    {
        if ($id === null){
            return $this->userRepository->findAll();
        } else {
            return $this->userRepository->find($id);
        }
    }

    public function getByUsername(string $username)
    {
        return $this->userRepository->findOneBy(array('username' => $username));
    }

    public function getAsArray()
    {
        $users = $this->get();
        $usersArray;
        foreach($users as $user) {
            $usersArray[$user->getUsername()] = $user->getPassword();
        }
        return $usersArray;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
        return $user;
    }

    public function remove(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush($user);
    }

    public function removeById(int $id)
    {
        $this->remove($this->get($id));
    }
}
