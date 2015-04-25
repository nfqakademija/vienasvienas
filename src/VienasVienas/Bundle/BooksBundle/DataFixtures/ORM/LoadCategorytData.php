<?php

namespace VienasVienas\Bundle\BooksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use VienasVienas\Bundle\BooksBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setCategoryName("Fiction");

        $category2 = new Category();
        $category2->setCategoryName("Computer Science");

        $manager->persist($category);
        $manager->persist($category2);
        $manager->flush();
    }
}
