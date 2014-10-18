<?php

namespace SONUser\Form;

use Zend\Form\Form,
    Zend\Form\Element\Text,
    Zend\Form\Element\Password;

/**
 * Description of User
 *
 * @author velho
 */
class Login extends Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct('Login', $options);

        $this->setAttribute('methods', 'post');

        $email = new Text('email');
        $email->setLabel("Email:")
                ->setAttributes(array('placeholder'=>'Entre com o email'));
        $this->add($email);

        $password = new Password('password');
        $password->setLabel("Password:")
                ->setAttribute('placeholder','Entre com a senha');
        $this->add($password);


        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Autenticar',
                'class' => 'btn-success',
                
            )
        ));
    }

}
