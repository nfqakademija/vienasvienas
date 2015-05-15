<?php
/**
 * Created by PhpStorm.
 * User: destas
 * Date: 5/14/15
 * Time: 5:21 PM
 */

namespace VienasVienas\Bundle\BooksBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Author;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $author1 = new Author();
        $author1->setAuthor('Anthony Doerr');

        $author2 = new Author();
        $author2->setAuthor('Cassandra Clare');

        $author3 = new Author();
        $author3->setAuthor('Rainbow Rowell');

        $author4 = new Author();
        $author4->setAuthor('Amy Poehler');

        $author5 = new Author();
        $author5->setAuthor('Kiera Cass');


        $manager->persist($author1);
        $manager->persist($author2);
        $manager->persist($author3);
        $manager->persist($author4);
        $manager->persist($author5);
        $manager->flush();

        $this->addReference('anthony doerr', $author1);
        $this->addReference('cassandra clare', $author2);
        $this->addReference('rainbow rowell', $author3);
        $this->addReference('amy poehler', $author4);
        $this->addReference('kiera cass', $author5);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}