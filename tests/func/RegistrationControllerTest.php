<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscription');
    }
   /* public function testVerfyEmailPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/verify/email');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Inscription');
    }*/
}
