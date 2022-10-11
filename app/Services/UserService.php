<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use App\Models\User;
use Psr\Log\LoggerInterface;


final class UserService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function signUp(string $email): User
    {
        $newUser = new User($email);

        $this->em->persist($newUser);
        $this->em->flush();
        
        $this->logger->info("User {$email} signed up");

        return $newUser;
    }
}