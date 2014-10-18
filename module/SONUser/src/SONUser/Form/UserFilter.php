<?php

namespace SONUser\Form;

use Zend\InputFilter\InputFilter;

/*
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFilter
 *
 * @author velho
 */
class UserFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode estar em branco'))))));

        $validator = new \Zend\Validator\EmailAddress();
        $validator->setOptions(array('domain' => FALSE));
        $this->add(array(
            'name' => 'email',
            'validators' => array($validator)
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode estar em branco'))))));
        
       $this->add(array(
            'name' => 'confirmation',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode estar em branco')),
                    'name' => 'Identical',
                    'options'=>array(
                        'token'=>'password',
                    )
                    )
                )));
    }

}
