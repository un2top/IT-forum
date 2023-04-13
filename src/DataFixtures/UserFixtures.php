<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user) {
            $user
                ->setFirstName($this->faker->name)
                ->setEmail($this->faker->email)
                ->setPassword($this->passwordEncoder->encodePassword($user, '12345'))
                ->setIsActive($this->faker->boolean(70) ? true:false);

        });

        $manager->flush();
    }
}
