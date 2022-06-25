<?php

namespace App\Tests;
use App\Entity\Annonce;
use PHPUnit\Framework\TestCase;

class AnnonceTest extends TestCase
{
    private Annonce $annonce ;
    
    protected function setUp():void
    {
        parent:: setUp();
        $annonce =new Annonce();
    }

    public function testGetTitle() :void
    {
        $annonce=new Annonce();
        $value ="test titre";
        $response = $annonce->setTitle($value);

        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getTitle());
    }
    public function testGetType() :void
    {
        $annonce=new Annonce();
        $value =false;
        $response = $annonce->setType($value);

        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getType());
    }
    public function testGetIdannonce() :void
    {
        $annonce=new Annonce();
        $value =22;
        $response = $annonce->setIdannonce($value);

        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getIdannonce());
    }

    public function testGetContent() :void
    {
        $annonce=new Annonce();
        $value ="tester le contenu de l'annonce";
        $response = $annonce->setContent($value);

        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getContent());
    }
    public function testGetLocation() :void
    {
        $annonce=new Annonce();
        $value ="tester l'adresse de l'annonce";
        $response = $annonce->setLocation($value);

        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getLocation());
    }
    public function testGetPublicationDate() :void
    {
        $annonce=new Annonce();
        $value =new \DateTime();
        $response = $annonce->setPublicationDate($value);
        self::assertInstanceOf( Annonce::class, $response);
        self::assertEquals($value ,$annonce->getPublicationDate());
    }


    
}   