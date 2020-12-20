<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserCategory;
use App\DataFixtures\UserCategoryFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;
    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $category = $this->getReference(UserCategoryFixtures::MUSICIAN_REFERENCE);
        $user = new User();

        $user->setCategory($category);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'musicien01'));
        $user->setEmail('musicien@upsidedown.com');
        $user->setRoles(['ROLE_USER']);
        $user->setLastname('Jhon');
        $user->setFirstname('Doe');
        $user->setCity('Rouen');
        $user->setZipCode('76000');
        $user->setAdressLine1('2 Place du Général de Gaulle');
        $user->setCivility('Mr');

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }

    public function getDependencies()
    {
        return array(
            UserCategoryFixtures::class,
        );
    }
}


