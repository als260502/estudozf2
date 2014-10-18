<?php
namespace SONUser\Form;

use Zend\Form\Form,
 Zend\Form\Element\Hidden,
 Zend\Form\Element\Text,
 Zend\Form\Element\Password,
 Zend\Form\Element\Csrf,
 Zend\Form\Element\Submit;       

/**
 * Description of User
 *
 * @author velho
 */
class User  extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct('user', $options);
        $this->setInputFilter(new UserFilter());
        $this->setAttribute('methods', 'post');
        
        $id = new Hidden('id');
        $this->add($id);
        
        $nome = new Text('nome');
        $nome->setLabel("Nome:")
                ->setAttribute('placeholder', 'Entre com o nome');
        $this->add($nome);
        
        $email = new Text('email');
        $email->setLabel("Email:")
                ->setAttribute('placeholder', 'Entre com o email');
        $this->add($email);
        
        $password = new Password('password');
        $password->setLabel("Password:")
                ->setAttribute('placeholder', 'Entre com a senha');
        $this->add($password);
        
        $confirmation = new Password('confirmation');
        $confirmation->setLabel("Redigite:")
                     ->setAttribute('placeholder', 'confirme a senha');
        $this->add($confirmation);
        
        $csrf = new Csrf('security');
        $this->add($csrf);
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' =>'btn-success'
            )
        ));
        
        
    }
}
