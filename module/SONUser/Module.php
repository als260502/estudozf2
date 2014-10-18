<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SONUser;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use SONUser\Auth\Adapter as AuthAdapter;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init(ModuleManager $moduleManager) {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', 
                MvcEvent::EVENT_DISPATCH, array($this, 'validaAuth'), 100);
    }

    public function validaAuth($e) {

        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("SONUser"));

        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();

        if (!$auth->hasIdentity() and ( $matchedRoute == 'sonuser-admin' or
                $matchedRoute == 'sonuser-admin/paginator')) {
            return $controller->redirect()->toRoute('sonuser-auth');
        }
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                __NAMESPACE__ . '\Mail\Transport' => function ($sm) {
                    $config = $sm->get('Config');

                    $transport = new SmtpTransport;
                    $options = new SmtpOptions($config['mail']);
                    $transport->setOptions($options);

                    return $transport;
                },
                __NAMESPACE__ . '\Service\User' => function($sm) {

                    return new Service\User($sm->get('Doctrine\ORM\EntityManager'), $sm->get(__NAMESPACE__ . '\Mail\Transport'), $sm->get('View'));
                },
                __NAMESPACE__ . '\Auth\Adapter' => function($sm) {

                    return new AuthAdapter($sm->get('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }

    public function getViewHelperConfig() {

        return array(
            'invokables' => array(
                'UserIdentity' => new View\Helper\UserIdentity()
            )
        );
    }

}
