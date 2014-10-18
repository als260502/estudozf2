<?php

namespace SONUser\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author velho
 */
class UserRepository extends EntityRepository{

    
    public function findByEmailAndPassword($email, $password){
        
        $user = $this->findOneByEmail($email);
        if($user)
        {
            
            $hashsenha =$user->encryptPassword($password);
            
            if($hashsenha == $user->getPassword())
                return $user;
            else
                return false;
        }
    }
}


