<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\UserCategory;

class UserCategoryFixtures extends Fixture
{
    public const MUSICIAN_REFERENCE = 'musician-category';

    public function load(ObjectManager $manager)
    {
        $category = new UserCategory();
        $category->setTitle('musicien');
        $manager->persist($category);

        $manager->flush();
        $this->addReference(self::MUSICIAN_REFERENCE, $category);

    }
}
