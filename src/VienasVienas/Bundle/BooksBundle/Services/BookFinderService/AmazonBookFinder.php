<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/23/15
 * Time: 2:11 PM
 */

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;


use Symfony\Component\BrowserKit\Response;
use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

class AmazonBookFinder implements BookFinderServiceInterface
{

    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getContent($isbn);
        return $content;
    }


    public function getContent(Isbn $isbn)
    {
        $response = 'Medium';
        return $this->getQuery($isbn, $response);
    }

    public function getComments(Isbn $isbn)
    {
        $response = 'Reviews';
        return $this->getQuery($isbn, $response);
    }

    public function getQuery(Isbn $isbn, $response)
    {
        $awsAccessKeyID = 'AKIAJXXI3QWCQW7QVGAQ';
        $awsSecretKey = '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';
        $awsAssociateTag = 'librarbooks-20';
        $host = 'ecs.amazonaws.com';
        $path = '/onca/xml';

        //query tag's
        $args = array(
            'AssociateTag' => $awsAssociateTag,
            'AWSAccessKeyId' => $awsAccessKeyID,
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
        foreach(array_keys($args) as $key)
        {
            $parts[] = $key . "=" . $args[$key];
        }

        // Constructing string to sign
        $stringToSign = "GET\n" . $host . "\n" . $path . "\n" . implode("&", $parts);
        $stringToSign = str_replace('+', '%20', $stringToSign);
        $stringToSign = str_replace(':', '%3A', $stringToSign);
        $stringToSign = str_replace(';', urlencode(';'), $stringToSign);

        // Signing the request
        $signature = hash_hmac("sha256", $stringToSign, $awsSecretKey, true);

        // Base64 encode the signature and make it URL safe
        $signature = base64_encode($signature);
        $signature = str_replace('+', '%2B', $signature);
        $signature = str_replace('=', '%3D', $signature);

        // Constructing the URL
        $url = 'http://' . $host . $path . '?' . implode("&", $parts) . "&Signature=" . $signature;

        $rawData = file_get_contents($url);
        $metadata = simplexml_load_string($rawData);
        $metadata = json_encode($metadata);

        return $metadata;
    }
}

