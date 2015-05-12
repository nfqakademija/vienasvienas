<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 5/9/15
 * Time: 7:00 PM
 */
namespace VienasVienas\Bundle\BooksBundle\Services\SearchService;

use Symfony\Component\HttpFoundation\Request;
use FOS\ElasticaBundle\Elastica;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class BooksSearch
 * @package VienasVienas\Bundle\BooksBundle\Services\SearchService
 */
class BooksSearch
{

    /**
     * @param $finder
     * @param Book $book
     */
    public function __construct($finder, Book $book)
    {
        $this->finder = $finder;
        $this->book = $book;
    }

    /**
     * @param $books
     * @return array
     */
    public function findBooksAPI($books)
    {
        foreach ($books as $result) {

            $title =  (string) $result->getTitle();
            $author = (string) $result->getAuthor();
            $id = (string) $result->getId();
            $image = $result->getCover();
            $data[] = array(
                'query' => $author . ' - ' . $title,
                'id' => $id,
                'image' => $image
             );
        }
        return $data;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getBooks(Request $request)
    {
        $searchTerm = $request->query->get('q');
        $searchTerm = preg_replace('/[^\w\s]/', ' ', $searchTerm);
        $searchQuery = new \Elastica\Query\QueryString();
        $searchQuery->setParam('query', $searchTerm);
        $searchQuery->setDefaultOperator('AND');
        $searchQuery->setParam('fields', array(
            'Author',
            'title',
            'isbn',
        ));
        $books = $this->finder->find($searchQuery);
        return $books;
    }
}