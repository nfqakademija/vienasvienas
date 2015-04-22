<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/21/15
 * Time: 6:18 PM
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Books;


class LoadBookData implements FixtureInterface {

    public function load(ObjectManager $manager)
    {
        $book = new Books();
        $book->setIsbn('554646444');
        $book->setCategoryId('55');
        $book->setAuthor('Jonas');
        $book->setAbout('asdwjenejwf erjncje rcjenc ');
        $book->setTitle('pavadinimas?');
        $book->setCover('none');
        $book->setPages('25');
        $book->setIsAvailable(true);
        $book->setCategoryId(5);
        $book->setRating(4.6);
        $book->setRegistrationDate(new \DateTime("now"));

        $manager->persist($book);
        $manager->flush();
    }

}