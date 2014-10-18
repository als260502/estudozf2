<?php

namespace SONAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
 Doctrine\Common\Persistence\ObjectManager;

use SONAcl\Entity\Role;
/**
 * Description of LoadRole
 *
 * @author velho
 */
class LoadRole  extends AbstractFixture{
    public function load(ObjectManager $manager) {
     
        $role = new Role;
        $role->setNome("visitante");
        $manager->persist($role);
        $manager->flush();
        
    }

}
