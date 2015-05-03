<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/23/15
 * Time: 2:11 PM
 */

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;

use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

/**
 * Class AmazonBookFinder
 * @package VienasVienas\Bundle\BooksBundle\Services\BookFinderService
 */
class AmazonBookFinder implements BookFinderServiceInterface
{
    private $parser;
    private $awsAccessKeyID;
    private $awsSecretKey;
    private $awsAssociateTag;

    /**
     * @param AmazonBookParser $parser
     * @param $awsAccessKeyID
     * @param $awsSecretKey
     * @param $awsAssociateTag
     */
    public function __construct(AmazonBookParser $parser, $awsAccessKeyID, $awsSecretKey, $awsAssociateTag)
    {
        $this->parser = $parser;
        $this->awsAccessKeyID = $awsAccessKeyID;
        $this->awsSecretKey = $awsSecretKey;
        $this->awsAssociateTag = $awsAssociateTag;
    }

    /**
     * @param Isbn $isbn
     * @return \VienasVienas\Bundle\BooksBundle\Entity\Book
     */
    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getContent($isbn);
        return $this->parser->parseBook($content);
    }

    /**
     * @param Isbn $isbn
     * @return \SimpleXMLElement
     */
    public function getContent(Isbn $isbn)
    {
        $response = 'Medium';
        return $this->getQuery($isbn, $response);
    }

    /**
     * @param Isbn $isbn
     * @return \SimpleXMLElement|string
     */
    public function getComments(Isbn $isbn)
    {
        $response = 'Reviews';
        $comments = $this->getQuery($isbn, $response);
        //counting review items in json
        $count = count($comments ->{'Items'}->{'Item'});
        // if no review, return empty string
        if ($count <=0) {
            return "";
        };
        //looking for element with review
        for ($i = 0; $i <= $count; $i++) {
            if ($comments ->{'Items'}->{'Item'}[$i]->{'CustomerReviews'}->{'HasReviews'} == "true") {
                $comments = $comments ->{'Items'}->{'Item'}[$i]->{'CustomerReviews'}->{'IFrameURL'};
                $comments = '<iframe src="' . $comments . '" width="100%" height="100%"></iframe>';
                return $comments;
            }
        }
        // if no reviews or some mistake, return empty string
        return "";
    }

    /**
     * @param Isbn $isbn
     * @param $response
     * @return \SimpleXMLElement
     */
    public function getQuery(Isbn $isbn, $response)
    {
        $host = 'ecs.amazonaws.com';
        $path = '/onca/xml';

        //query tag's
        $args = array(
            'AssociateTag' => $this->awsAssociateTag,
            'AWSAccessKeyId' => $this->awsAccessKeyID,
            'IdType' => 'ISBN',
            'ItemId' => $isbn->getIsbn(),
            'Operation' => 'ItemLookup',
            'ResponseGroup' => $response,
            'SearchIndex' => 'Books',
            'Service' => 'AWSECommerceService',
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Version'=> '2009-01-06'
        );

        ksort($args);
        $parts = array();
        foreach (array_keys($args) as $key) {
            $parts[] = $key . "=" . $args[$key];
        }

        // Constructing string to sign
        $stringToSign = "GET\n" . $host . "\n" . $path . "\n" . implode("&", $parts);
        $stringToSign = str_replace('+', '%20', $stringToSign);
        $stringToSign = str_replace(':', '%3A', $stringToSign);
        $stringToSign = str_replace(';', urlencode(';'), $stringToSign);

        // Signing the request
        $signature = hash_hmac("sha256", $stringToSign, $this->awsSecretKey, true);

        // Base64 encode the signature and make it URL safe
        $signature = base64_encode($signature);
        $signature = str_replace('+', '%2B', $signature);
        $signature = str_replace('=', '%3D', $signature);

        // Constructing the URL
        $url = 'http://' . $host . $path . '?' . implode("&", $parts) . "&Signature=" . $signature;

        $rawData = file_get_contents($url);
        $metadata = simplexml_load_string($rawData);
        return $metadata;
    }
}

