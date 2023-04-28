<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $this->create(User::class, function (User $user) use ($manager){
            $user
                ->setFirstName('admin')
                ->setEmail('admin@symfony.skillbox')
                ->setPassword($this->passwordEncoder->encodePassword($user, '54321'))
                ->setRoles(["ROLE_ADMIN"])
                ->setIsActive(true);

            $manager->persist(new ApiToken($user));

        });
        $this->create(User::class, function (User $user) use ($manager){
            $user
                ->setFirstName('api')
                ->setEmail('api@symfony.skillbox')
                ->setPassword($this->passwordEncoder->encodePassword($user, '54321'))
                ->setRoles(["ROLE_API"])
                ->setIsActive(true);

            for($i=0;$i<3;$i++){
                $manager->persist(new ApiToken($user));
            }

        });
        $this->createMany(User::class, 10, function (User $user) use ($manager){
            $user
                ->setFirstName($this->faker->name)
                ->setEmail($this->faker->email)
                ->setPassword($this->passwordEncoder->encodePassword($user, '12345'))
                ->setIsActive($this->faker->boolean(70) ? true:false);
            $manager->persist(new ApiToken($user));
        });

        $manager->flush();
    }
}
