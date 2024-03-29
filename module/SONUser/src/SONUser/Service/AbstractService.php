<?php

namespace SONUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation\Hydrator;
use SONUser\Entity\User; 
/**
 * Description of AbstractService
 *
 * @author velho
 */
abstract class AbstractService {
    protected $em;
    
    protected $entity;
    
    public function __construct(EntityManager $em) {
       
        $this->em = $em;
    }
    
    public function insert(array $data){
        $entity = new $this->entity($data);
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function update(array $data){
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function delete($id){
        $entity = $this->em->getReference($this->entity, $id);
        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            return $entity;
        }
    }
}
