<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 5/18/15
 * Time: 9:12 AM
 */

namespace VienasVienas\Bundle\BooksBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VienasVienas\Bundle\BooksBundle\Entity\Author;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class InsertFromFileCommand
 * @package VienasVienas\Bundle\BooksBundle\Command
 */
class InsertFromFileCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */

    protected function configure()
    {
        $this
            ->setName('add:from:file')
            ->setDescription('Tool for inserting  books to database from txt file')
            ->addArgument(
                'fileNumber',
                InputArgument::OPTIONAL,
                'From which file you want to start?'
            )
            ->addArgument(
                'until',
                InputArgument::OPTIONAL,
                'how many files to scan?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $s = microtime(true);
        $total = 0;
        $fileNumber = $input->getArgument('fileNumber');
        $until = $input->getArgument('until');

        for ($i=0; $i <= $until; $i++) {
            $file = 'input/' . $fileNumber;
            $output->writeln('Started reading from ' . $file);

            $result = $this->getFileInfo($file);
            $result = $this->removeUnused($result);
            $number = $this->insertData($result);

            $fileNumber++;
            $total = $total + $number;
            $output->writeln('Was inserted:' . $number);

        }

        $output->writeln('<info>Done</info>');
        $e = microtime(true);
        $output->writeln('Inserted ' . $total . ' objects in ' . ($e - $s) . ' seconds' . PHP_EOL);

    }

    /**
     * @param $file
     * @return int
     */
    private function insertData($file)
    {
        $number = 1;
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        //using batch for Bulk insertion
        $batchSize = 20;

        foreach ($file as $lines) {
            //if no title or isbn, skip line
            if (isset($lines['title'])) {
                if (isset($lines['isbn_13']) || (isset($lines['isbn_10']))) {
                    $book = $this->setData($lines);
                    $number++;
                    $em->persist($book);

                    if (($number % $batchSize) === 0) {
                        $em->flush();
                        $em->clear();
                    }
                }
            }
        }

        $em->flush();
        $em->clear();

        return $number;
    }

    /**
     * @param $file
     * @return Book
     */
    private function setData($file)
    {
        $book = new Book();
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $title = (string) $file['title'];
        $book->setTitle($title);
        $book->setRegistrationDate(new \DateTime());
        $book->getQuantity(1);
        $book->setRating(0);
        $book->setCover('<img src="/img/no_book_cover.jpg">');


        //setting ISBN 13 or ISBN 10
        if (isset($file['isbn_13'])) {
            $isbn = (string) $file['isbn_13'][0];
        } else {
            $isbn = (string) $file['isbn_10'][0];
        }
        $book->setIsbn($isbn);

        echo $isbn . " ";
        //setting best description
        if (isset($file['description'])) {
            //Description is object inside array (but not always)
            $ob = $file['description'];
            if (isset($ob->{'value'})) {
                $about = (string)$ob->{'value'};
            } else {
                $about = (string) $file['description'];
            }
        } elseif (isset($file['subtitle'])) {
            $about = (string) $file['subtitle'];
        } else {
            $about = " ";
        }
        $book->setAbout($about);


        //if exist, setting page count
        if (isset($file['number_of_pages'])) {
            $pages = (integer) $file['number_of_pages'];
            $book->setPages($pages);
        } else {
            $book->setPages(0);
        }
        //getting author name
        if (isset($file['publishers'])) {
            $author = (string) $file['publishers'][0];
        } else {
            $author = 0;
        }
        //searching for existing Author in database, if no result create new
        $authorExist = $em->getRepository('BooksBundle:Author')->findOneBy(array( 'author' => $author));
        if (isset ($authorExist)) {
            $book->setAuthor($authorExist);
        } else {
            $newAuthor = new Author();
            $newAuthor->setAuthor($author);
            $book->setAuthor($newAuthor);
        }

        return $book;
    }

    /**
     * @param $file
     * @return array|int
     */
    private function getFileInfo($file)
    {
        $myfile = fopen($file, "r") or die("Unable to open file!");
        $linesInFile = array();
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

    /**
     * @param $linesInfile
     * @return array
     */
    private function removeUnused($linesInfile)
    {
        $result = [];
        $json = [];
        $i = 0;
        foreach ($linesInfile as $lines) {
            $result[$i] = substr($lines, 61);
            $json[$i] = (array) json_decode($result[$i]);
            $i++;
        }
        return $json;
    }
}
