<?php

namespace SONAcl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use SONAcl\Entity\Role;


/**
 * Description of RolesController
 *
 * @author velho
 */
class RolesController extends AbstractActionController{
  
    public function indexAction(){
                
       return new ViewModel();
    }
}
