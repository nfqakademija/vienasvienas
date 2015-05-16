<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 5/13/15
 * Time: 7:52 PM
 */

namespace VienasVienas\Bundle\BooksBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use VienasVienas\Bundle\BooksBundle\Entity\Category;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

class BulkBookAdderCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this
            ->setName('add:books')
            ->setDescription('Tool for inserting  books to database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Insertion began:</comment>');


        $linesInFile = $this->getFileInfo('in.txt');
        $number = $this->insertData($linesInFile, $output);

        $output->writeln('done');
        $output->writeln('total was inserted:' . $number);
    }


    private function getFileInfo($file)
    {
        $myfile = fopen($file, "r") or die("Unable to open file!");
        while (!feof($myfile)) {
            $linesInFile[] = fgets($myfile);
        }
        fclose($myfile);
        if (isset($linesInFile)) {
            return $linesInFile;
        } else {
            return 0;
        }
    }

    private function insertData($linesInFile, $output)
    {
        $google = $this->getContainer()->get('google.books');
        $amazon = $this->getContainer()->get('amazon.books');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $isbn = new Isbn();
        $book = new Book();
        $number = 0;


        foreach ($linesInFile as $string) {
            //getting isbn from Open Library dump
            $string = preg_split('/isbn_13/', $string);
            if (isset($string[1])) {
                $value = str_split($string[1], 23);
                $isbnValue = preg_replace('/\D/', '', $value[0]);

                // $output->write($isbnValue);

                $isbn->setIsbn($isbnValue);

                $book = $google->getBookByIsbn($isbn);
                if (null == $book->getIsbn()) {
                    $book = $amazon->getBookByIsbn($isbn);
                }
                $pages = $book->getPages();
                $image = $book->getCover();
                $about = $book->getAbout();

                if ($about !== "") {
                    if ($image !=="") {
                        $em->persist($book);
                        $em->flush();
                        $em->clear();
                        $output->writeln($isbnValue);
                        $number++;
                    }
                }
            }
        }

        return $number;
    }
}