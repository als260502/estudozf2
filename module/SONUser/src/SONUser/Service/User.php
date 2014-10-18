<?php

namespace SONUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use SONBase\Mail\Mail;
use SONUser\Service\AbstractService;

/**
 * Description of User
 *
 * @author velho
 */
class User extends AbstractService {

    protected $transport;
    protected $view;

    public function __construct(EntityManager $em, SmtpTransport $transport, $view) {

        parent::__construct($em);

        $this->entity = "SONUser\Entity\User";
        $this->transport = $transport;
        $this->view = $view;
    }

    public function insert(array $data) {
        $entity = parent::insert($data);

        $dataEmail = array('nome' => $data['nome'], 'activationKey' => $entity->getActivationKey());

        if ($entity) {

            $mail = new Mail($this->transport, $this->view, 'add_user');
            $mail->setSubject("Confirmação de cadastro")
                    ->setTo('email')
                    ->setData($dataEmail)
                    ->prepare();
            //->send();

            return $entity;
        }
    }

    public function activate($key) {
        $repo = $this->em->getRepository("SONUser\Entity\User");
        $user = $repo->findOneByActivationKey($key);

        if ($user && !$user->getActive()) {
            $user->setActive(TRUE);

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
    }

    public function update(array $data) {
        
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        if(empty($data['password']))
            unset ($data['password']);

        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

}
