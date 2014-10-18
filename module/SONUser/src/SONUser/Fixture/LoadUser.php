<?php
namespace SONUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use SONUser\Entity\User;

class LoadUser extends AbstractFixture{
    
    
    public function load(ObjectManager $manager) {
        
        $user = new User;
        $user->setActive(true)
            ->setEmail("als260503@als.com")
            ->setNome("andré")
            ->setPassword(123456);
        
        $manager->persist($user);
        $manager->flush();
              
    }

}

