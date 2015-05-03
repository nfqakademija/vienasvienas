<?php

namespace VienasVienas\Bundle\BooksBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testGetBookAPI()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        print_r($crawler);
        $this->assertTrue($crawler->filter('html:contains("Welcome")')->count() > 0);

    }
}
