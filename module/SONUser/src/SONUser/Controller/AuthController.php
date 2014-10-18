<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use SONUser\Form\Login as LoginForm;

/**
 * Description of AuthController
 *
 * @author velho
 */
class AuthController extends AbstractActionController {

    public function indexAction() {
        $form = new LoginForm;
        $error = false;
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $data = $request->getPost()->toArray();

                //criando storage para gravar sessao da autenticação
                $sessionStorage = new SessionStorage("SONUser");

                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage); //definindo o sessionstprage para auth

                $authAdapter = $this->getServiceLocator()->get('SONUser\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

                
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid()) {
                /*  
                      $user = $auth->getIdentity();
                      $user = $user['user'];
                      $sessionStorage->write($user, NULL);
                  */

                  $sessionStorage->write($auth->getIdentity()['user'], null);

                    return $this->redirect()->toRoute('sonuser-admin/default', array('controller' => 'users'));
                } else
                    $error = true;
            }
        }
        return  new ViewModel(array('form' => $form, 'error'=>$error));
    }
    
    public function logoutAction(){
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("SONUser"));
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute("sonuser-auth");
    }

}
