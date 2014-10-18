<?php

namespace SONAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\HasLifecycleCallbacks
 * #@ORM\Table(name="sonacl_roles", indexes={@ORM\Index(name="fk_sonacl_roles_sonacl_roles1_idx", columns={"parent_id"})})
 * @ORM\Entity
 * @ORM\Table(name="sonacl_roles")
 * @ORM\Entity(repositoryClass="SONAcl\Entity\RoleRepository")
 */
class Role {

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
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     */
    private $isAdmin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * 
     *
     * @ORM\OneToOne(targetEntity="SONAcl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    public function __construct($options = array()) {
        /*
          $hydrator = new Hydrator\ClassMethods;
          $hydrator->hydrate($opton, $this);
         */
        (new Hydrator\ClassMethods())->hydrate($options, $this);

        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
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

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function toString() {
        
    }

    public function toArray() {

        if (isset($this->parent))
            $parent = $this->parent->getId();
        else
            $parent = false;

        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'isAdmin' => $this->isAdmin,
            'parent' => $parent
        );
    }

}
