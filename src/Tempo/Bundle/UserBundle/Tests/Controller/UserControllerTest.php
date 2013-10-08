<?php

namespace Tempo\Bundle\ProjectBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/login');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        
        
        $form = $crawler->selectButton('submit');
       

        // submit the form
        $crawler = $client->submit($form, array(
            '_username' => 'test',
            '_password' => 'test',
        ));
        
    }
    
}