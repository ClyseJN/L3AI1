<?php

namespace App\Tests;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user ;
    
    protected function setUp():void
    {
        parent:: setUp();
        $user =new User();
    }

    public function testGetPassword() :void
    {
        $user=new User();
        $value ="motdepasse";
        $response = $user->setPassword($value);

        self::assertInstanceOf( user::class, $response);
        self::assertEquals($value ,$user->getPassword());
    }
  
    public function testGetUserIdentifier() :void
    {
        $user=new User();
        $value ="mail@test.fr";
        $response = $user->setUserIdentifier($value);

        self::assertInstanceOf( user::class, $response);
        self::assertEquals($value ,$user->getUserIdentifier());
    }
    
    
}   