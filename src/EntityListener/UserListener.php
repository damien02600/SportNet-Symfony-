<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // Avant de persisté il va voir la méthode encodePassword
    public function prePersist(User $user)
    {
        $this->encodePassword($user);
    }



    // Encode password basé de plain password
    public function encodePassword(User $user)
    {
        if ($user->getPlainPassword() === null) {
            return;
        }
        // Je hash le password
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
        );
    }
}