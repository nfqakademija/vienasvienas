<?php

namespace VienasVienas\Bundle\BooksBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $book1 = new Book();
        $book1->setTitle('All the Light We Cannot See');
        $book1->setAuthor($this->getReference('anthony doerr'));
        $book1->setQuantity(1);
        $book1->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book1->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book1->setIsbn('9781476746586');
        $book1->setPages(350);
        $book1->setRating('3.5');
        $book1->setRegistrationDate(new \DateTime('now'));
        $book1->setTimesRead(10);
        $book1->addCategory($this->getReference('fiction'));



        $book2 = new Book();
        $book2->setTitle('All the Light We Cannot See');
        $book2->setAuthor($this->getReference('cassandra clare'));
        $book2->setQuantity(1);
        $book2->setAbout(
            'In this dazzling and long-awaited conclusion to the acclaimed Mortal
             Instruments series, Clary and her friends fight the greatest evil they
             have ever faced: Clary\'s own brother.
             Sebastian Morgenstern is on the move,
             systematically turning Shadowhunter against Shadowhunter.'
        );
        $book2->setCover('https://d.gr-assets.com/books/1389748702l/8755785.jpg');
        $book2->setIsbn('9781476746586');
        $book2->setPages(725);
        $book2->setRating('3.8');
        $book2->setRegistrationDate(new \DateTime('now'));
        $book1->setTimesRead(15);
        $book2->addCategory($this->getReference('computer science'));

        $book3 = new Book();
        $book3->setTitle('All the Light We Cannot See');
        $book3->setAuthor($this->getReference('rainbow rowell'));
        $book3->setQuantity(1);
        $book3->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book3->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book3->setIsbn('9781476746586');
        $book3->setPages(350);
        $book3->setRating('3.5');
        $book3->setRegistrationDate(new \DateTime('now'));
        $book1->setTimesRead(12);
        $book3->addCategory($this->getReference('art architecture'));

        $book4 = new Book();
        $book4->setTitle('All the Light We Cannot See');
        $book4->setAuthor($this->getReference('amy poehler'));
        $book4->setQuantity(1);
        $book4->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book4->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book4->setIsbn('9781476746586');
        $book4->setPages(350);
        $book4->setRating('3.5');
        $book4->setRegistrationDate(new \DateTime('now'));
        $book1->setTimesRead(10);
        $book4->addCategory($this->getReference('biography'));

        $book5 = new Book();
        $book5->setTitle('All the Light We Cannot See');
        $book5->setAuthor($this->getReference('kiera cass'));
        $book5->setQuantity(1);
        $book5->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book5->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book5->setIsbn('9781476746586');
        $book5->setPages(350);
        $book5->setRating('3.5');
        $book5->setRegistrationDate(new \DateTime('now'));
        $book5->addCategory($this->getReference('business'));

        $book6 = new Book();
        $book6->setTitle('All the Light We Cannot See');
        $book6->setAuthor($this->getReference('anthony doerr'));
        $book6->setQuantity(1);
        $book6->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book6->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book6->setIsbn('9781476746586');
        $book6->setPages(350);
        $book6->setRating('3.5');
        $book6->setRegistrationDate(new \DateTime('now'));
        $book6->addCategory($this->getReference('business'));

        $book7 = new Book();
        $book7->setTitle('All the Light We Cannot See');
        $book7->setAuthor($this->getReference('cassandra clare'));
        $book7->setQuantity(1);
        $book7->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book7->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book7->setIsbn('9781476746586');
        $book7->setPages(350);
        $book7->setRating('3.5');
        $book7->setRegistrationDate(new \DateTime('now'));
        $book7->addCategory($this->getReference('fiction'));

        $book8 = new Book();
        $book8->setTitle('All the Light We Cannot See');
        $book8->setAuthor($this->getReference('rainbow rowell'));
        $book8->setQuantity(1);
        $book8->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book8->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book8->setIsbn('9781476746586');
        $book8->setPages(350);
        $book8->setRating('3.5');
        $book8->setRegistrationDate(new \DateTime('now'));
        $book8->addCategory($this->getReference('fiction'));

        $book9 = new Book();
        $book9->setTitle('All the Light We Cannot See');
        $book9->setAuthor($this->getReference('amy poehler'));
        $book9->setQuantity(1);
        $book9->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book9->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book9->setIsbn('9781476746586');
        $book9->setPages(350);
        $book9->setRating('3.5');
        $book9->setRegistrationDate(new \DateTime('now'));
        $book9->addCategory($this->getReference('business'));

        $book10 = new Book();
        $book10->setTitle('All the Light We Cannot See');
        $book10->setAuthor($this->getReference('kiera cass'));
        $book10->setQuantity(1);
        $book10->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book10->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book10->setIsbn('9781476746586');
        $book10->setPages(350);
        $book10->setRating('3.5');
        $book10->setRegistrationDate(new \DateTime('now'));
        $book10->addCategory($this->getReference('science'));

        $book11 = new Book();
        $book11->setTitle('All the Light We Cannot See');
        $book11->setAuthor($this->getReference('anthony doerr'));
        $book11->setQuantity(1);
        $book11->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book11->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book11->setIsbn('9781476746586');
        $book11->setPages(350);
        $book11->setRating('3.5');
        $book11->setRegistrationDate(new \DateTime('now'));
        $book11->addCategory($this->getReference('business'));

        $book12 = new Book();
        $book12->setTitle('All the Light We Cannot See');
        $book12->setAuthor($this->getReference('cassandra clare'));
        $book12->setQuantity(1);
        $book12->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book12->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book12->setIsbn('9781476746586');
        $book12->setPages(350);
        $book12->setRating('3.5');
        $book12->setRegistrationDate(new \DateTime('now'));
        $book12->addCategory($this->getReference('garden'));

        $book13 = new Book();
        $book13->setTitle('City of Heavenly Fire');
        $book13->setAuthor($this->getReference('rainbow rowell'));
        $book13->setQuantity(1);
        $book13->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book13->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book13->setIsbn('9781476746586');
        $book13->setPages(350);
        $book13->setRating('3.5');
        $book13->setRegistrationDate(new \DateTime('now'));
        $book13->addCategory($this->getReference('history'));

        $book15 = new Book();
        $book15->setTitle('All the Light We Cannot See');
        $book15->setAuthor($this->getReference('amy poehler'));
        $book15->setQuantity(1);
        $book15->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book15->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book15->setIsbn('9781476746586');
        $book15->setPages(350);
        $book15->setRating('3.5');
        $book15->setRegistrationDate(new \DateTime('now'));
        $book15->addCategory($this->getReference('crime'));

        $book16 = new Book();
        $book16->setTitle('All the Light We Cannot See');
        $book16->setAuthor($this->getReference('kiera cass'));
        $book16->setQuantity(1);
        $book16->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book16->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book16->setIsbn('9781476746586');
        $book16->setPages(350);
        $book16->setRating('3.5');
        $book16->setRegistrationDate(new \DateTime('now'));
        $book16->addCategory($this->getReference('children'));

        $book17 = new Book();
        $book17->setTitle('All the Light We Cannot See');
        $book17->setAuthor($this->getReference('anthony doerr'));
        $book17->setQuantity(1);
        $book17->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book17->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book17->setIsbn('9781476746586');
        $book17->setPages(350);
        $book17->setRating('3.5');
        $book17->setRegistrationDate(new \DateTime('now'));
        $book17->addCategory($this->getReference('biography'));

        $book18 = new Book();
        $book18->setTitle('All the Light We Cannot See');
        $book18->setAuthor($this->getReference('cassandra clare'));
        $book18->setQuantity(1);
        $book18->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book18->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book18->setIsbn('9781476746586');
        $book18->setPages(350);
        $book18->setRating('3.5');
        $book18->setRegistrationDate(new \DateTime('now'));
        $book18->addCategory($this->getReference('art architecture'));

        $book19 = new Book();
        $book19->setTitle('All the Light We Cannot See');
        $book19->setAuthor($this->getReference('rainbow rowell'));
        $book19->setQuantity(1);
        $book19->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book19->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book19->setIsbn('9781476746586');
        $book19->setPages(350);
        $book19->setRating('3.5');
        $book19->setRegistrationDate(new \DateTime('now'));
        $book19->addCategory($this->getReference('science'));

        $book20 = new Book();
        $book20->setTitle('All the Light We Cannot See');
        $book20->setAuthor($this->getReference('amy poehler'));
        $book20->setQuantity(1);
        $book20->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book20->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book20->setIsbn('9781476746586');
        $book20->setPages(350);
        $book20->setRating('3.5');
        $book20->setRegistrationDate(new \DateTime('now'));
        $book20->addCategory($this->getReference('history'));

        $book21 = new Book();
        $book21->setTitle('All the Light We Cannot See');
        $book21->setAuthor($this->getReference('kiera cass'));
        $book21->setQuantity(1);
        $book21->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book21->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book21->setIsbn('9781476746586');
        $book21->setPages(350);
        $book21->setRating('3.5');
        $book21->setRegistrationDate(new \DateTime('now'));
        $book21->addCategory($this->getReference('crime'));

        $book22 = new Book();
        $book22->setTitle('All the Light We Cannot See');
        $book22->setAuthor($this->getReference('anthony doerr'));
        $book22->setQuantity(1);
        $book22->setAbout(
            'Marie-Laure lives with her father in Paris near the Museum of Natural History,
         where he works as the master of its thousands of locks. When she is six, Marie-Laure goes blind
         and her father builds a perfect miniature of their neighborhood so she can memorize it by touch
         and navigate her way home.'
        );
        $book22->setCover('<img src="https://books.google.lt/books/content?id=2S_Y6Zm02BQC&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71fE6BN_l-2vtNsr3auYFa5o-0H9KHuC-LapMc3AzwICa9loqUA2PG83yYDYGp3zHaL-A7mpeCbMuLMUgAh2H-7GfzsZvi6rGkvdgF4XeAvJKMrKA-E-_7SOgWSCbO3D9T5mTy2">');
        $book22->setIsbn('9781476746586');
        $book22->setPages(350);
        $book22->setRating('3.5');
        $book22->setRegistrationDate(new \DateTime('now'));
        $book22->addCategory($this->getReference('children'));

        $manager->persist($book1);
        $manager->persist($book2);
        $manager->persist($book3);
        $manager->persist($book4);
        $manager->persist($book5);
        $manager->persist($book6);
        $manager->persist($book7);
        $manager->persist($book8);
        $manager->persist($book9);
        $manager->persist($book10);
        $manager->persist($book11);
        $manager->persist($book12);
        $manager->persist($book13);
        $manager->persist($book15);
        $manager->persist($book16);
        $manager->persist($book17);
        $manager->persist($book18);
        $manager->persist($book19);
        $manager->persist($book20);
        $manager->persist($book21);
        $manager->persist($book22);

        $manager->flush();

        $this->addReference('book1', $book1);
        $this->addReference('book2', $book2);
        $this->addReference('book3', $book3);
        $this->addReference('book4', $book4);
        $this->addReference('book5', $book5);
        $this->addReference('book6', $book6);
        $this->addReference('book7', $book7);
        $this->addReference('book8', $book8);
        $this->addReference('book9', $book9);
        $this->addReference('book10', $book10);
        $this->addReference('book11', $book11);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}

