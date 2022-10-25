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

    public function signUp(string $email, string $pass)
    {
        try{
            $newUser = new User($email, $pass);
            $this->em->persist($newUser);
            $this->em->flush();
            $this->logger->info("User {$email} signed up");
            return $newUser;
        }catch (\Throwable $e) {
            $newUser = null;
            $this->logger->error("User {$email} failed to sign up");
            throw $e;
            return $newUser;
        }
    }

    public function logIn($email, $pass){

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email, 'password' => hash('md5',$pass)]);

        if ($user) {
            $this->logger->info("User {$email} logged in");
            return $user;
        }

        return $user;

    }
}