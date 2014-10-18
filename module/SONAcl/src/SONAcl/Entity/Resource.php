<?php

namespace SONAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="sonacl_resources")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SONAcl\Entity\ResourceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Resource {

    public function __construct($options = array()) {
        /*
          $hydrator = new Hydrator\ClassMethods;
          $hydrator->hydrate($opton, $this);
         */
        (new Hydrator\ClassMethods())->hydrate($options, $this);

        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="string", length=45, nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setCreatedAt() {
        $this->createdAt = new \DateTime("now");
        return $this;
    }

    /**
     * 
     * @ORM\PrePersist
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime("now");
        return $this;
    }

    public function toArray() {
        (new Hydrator\ClassMethods())->extract($this);
    }

}
