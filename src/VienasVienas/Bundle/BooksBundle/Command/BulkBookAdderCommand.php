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
use Symfony\Component\Console\Input\InputArgument;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use VienasVienas\Bundle\BooksBundle\Entity\Category;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

/**
 * Class BulkBookAdderCommand
 * @package VienasVienas\Bundle\BooksBundle\Command
 */
class BulkBookAdderCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */

    protected function configure()
    {
        $this
            ->setName('add:books')
            ->setDescription('Tool for inserting  books to database')
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
        $output->writeln('<comment>Insertion began:</comment>');
        $output->writeln('Memory usage on start:' . memory_get_peak_usage());
        $fileNumber = $input->getArgument('fileNumber');
        $until = $input->getArgument('until');
        $total = 0;
        $number = 0;

        for ($i=0; $i <= $until; $i++) {
            $output->writeln('Memory usage before ' . $i . memory_get_peak_usage());

            $file = 'input/' . $fileNumber;
            $output->writeln('Started reading from ' . $file);

            $number = $this->update($file);


            $total = $total + $number;
            $output->writeln('Was inserted:' . $number);
            $fileNumber++;
        }
        $e = microtime(true);
        $output->writeln('total was inserted:' . $total);
        $output->writeln('Inserted ' . $number . ' objects in ' . ($e - $s) . ' seconds' . PHP_EOL);
        $output->writeln('Memory usage ' . memory_get_peak_usage());

    }

    /**
     * @param $file
     * @return int
     */
    private function update($file)
    {
        $linesInFile = $this->getFileInfo($file);
        $number = $this->insertData($linesInFile);
        return $number;
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
     * @param $linesInFile
     * @return int
     */
    private function insertData($linesInFile)
    {
        $google = $this->getContainer()->get('google.books');
        $amazon = $this->getContainer()->get('amazon.books');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $number = 1;
        $batchSize = 20;


        foreach ($linesInFile as $string) {
            //getting isbn from Open Library dump
            $string = preg_split('/isbn_13/', $string);
            $isbn = new Isbn();

            if (isset($string[1])) {
                $value = str_split($string[1], 23);
                $isbnValue = preg_replace('/\D/', '', $value[0]);


                $isbn->setIsbn($isbnValue);

                $book = $google->getBookByIsbn($isbn);
                if (null == $book->getIsbn()) {
                    $book = $amazon->getBookByIsbn($isbn);
                }

                $em->persist($book);
                $number++;
                if (($number % $batchSize) === 0) {
                    $em->flush();
                    $em->clear(); // Detaches all objects from Doctrine!
                }

            }
        }
        $em->flush();
        $em->clear();
        return $number;
    }
}