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
        $s = microtime(true);
        $output->writeln('<comment>Insertion began:</comment>');
        $output->writeln('Memory usage on start:' . memory_get_peak_usage());


        $linesInFile = $this->getFileInfo('in.txt');
        $output->writeln('Memory usage after reading file:' . memory_get_peak_usage());

        $number = $this->insertData($linesInFile, $output);
        $linesInFile = null;
        $output->writeln('<info>done</info>');
        $output->writeln('Memory usage in the end:' . memory_get_peak_usage());
        $output->writeln('total was inserted:' . $number);
        $e = microtime(true);
        echo ' Inserted' . $number . ' objects in ' . ($e - $s) . ' seconds' . PHP_EOL;

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
        $number = 1;
        //using Batch for Bulk inserts
        $batchSize = 5;


        foreach ($linesInFile as $string) {
            //getting isbn from Open Library dump
            $string = preg_split('/isbn_13/', $string);
            $book = new Book();
            $isbn = new Isbn();

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
                     //   if (($number % $batchSize) === 0) {
                            $em->flush();
                            $em->clear();
                         //   $output->writeln('->>> to SQL');
                            $output->writeln('Memory usage:' . memory_get_peak_usage());
                         //   $book = null;
                     //   }
                        $output->writeln($isbnValue);
                        $number++;
                    }
                }
            }
        }
        $em->flush();
        $em->clear();
        return $number;
    }
}