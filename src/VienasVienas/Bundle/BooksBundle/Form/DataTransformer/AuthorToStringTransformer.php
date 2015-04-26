<?php
/**
 * Created by PhpStorm.
 * User: destas
 * Date: 4/26/15
 * Time: 10:26 AM
 */

namespace VienasVienas\Bundle\BooksBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BooksBundle\Entity\Author;

class AuthorToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Author|null $author
     * @return string
     */
    public function transform($author)
    {
        if (null === $author) {
            return "";
        }

        return $author->getAuthor();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $name
     *
     * @return Author|null
     *
     * @throws TransformationFailedException if object (author) is not found.
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }

        $author = $this->om
            ->getRepository('BooksBundle:Author')
            ->findOneBy(array('author' => $name))
        ;

        if (null === $author) {
            throw new TransformationFailedException(sprintf(
                'An author with name "%s" does not exist!',
                $name
            ));
        }

        return $author;
    }
}
