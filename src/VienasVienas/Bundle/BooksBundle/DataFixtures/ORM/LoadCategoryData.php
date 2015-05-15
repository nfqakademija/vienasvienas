<?php

namespace VienasVienas\Bundle\BooksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setCategoryName('Fiction');

        $category2 = new Category();
        $category2->setCategoryName('Computer Science');

        $category3 = new Category();
        $category3->setCategoryName('Art, Architecture & Photography');

        $category4 = new Category();
        $category4->setCategoryName('Biography');

        $category5 = new Category();
        $category5->setCategoryName('Business, Finance & Law');

        $category6 = new Category();
        $category6->setCategoryName('Children\'s Books');

        $category7 = new Category();
        $category7->setCategoryName('Crime, Thrillers & Mystery');

        $category8 = new Category();
        $category8->setCategoryName('History');

        $category9 = new Category();
        $category9->setCategoryName('Home & Garden');

        $category10 = new Category();
        $category10->setCategoryName('Science Fiction & Fantasy');



        $manager->persist($category);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
        $manager->persist($category5);
        $manager->persist($category6);
        $manager->persist($category7);
        $manager->persist($category8);
        $manager->persist($category9);
        $manager->persist($category10);

        $manager->flush();

        $this->addReference('fiction', $category);
        $this->addReference('computer science', $category);
        $this->addReference('art architecture', $category);
        $this->addReference('biography', $category);
        $this->addReference('business', $category);
        $this->addReference('children', $category);
        $this->addReference('crime', $category);
        $this->addReference('history', $category);
        $this->addReference('garden', $category);
        $this->addReference('science', $category);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
