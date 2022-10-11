<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\User;

final class UserService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function signUp(string $email, string $pass): User
    {
        $newUser = new User($email, $pass);

        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }
}