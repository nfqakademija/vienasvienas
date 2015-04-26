<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/21/15
 * Time: 6:18 PM
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

class LoadBookData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $book = new Book();
        $book->setIsbn('554646444');
        $book->setAbout('asdwjenejwf erjncje rcjenc ');
        $book->setTitle('pavadinimas?');
        $book->setCover('none');
        $book->setPages('25');
        $book->setRating(4.6);
        $book->setQuantity(10);
        $book->setRegistrationDate(new \DateTime("now"));

        $manager->persist($book);
        $manager->flush();
    }

}