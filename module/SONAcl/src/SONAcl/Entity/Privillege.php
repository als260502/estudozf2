<?php

namespace SONAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="sonacl_privileges", indexes={@ORM\Index(name="fk_sonacl_privileges_sonacl_resources_idx", columns={"resources_id"}), @ORM\Index(name="fk_sonacl_privileges_sonacl_roles1_idx", columns={"role_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SONAcl\Entity\PrivillegeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Privilege {

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
     * @ORM\OneToOne(targetEntity="SONAcl\Entity\Resource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resources_id", referencedColumnName="id")
     * })
     */
    private $resources;

    /**
     * @ORM\OneToOne(targetEntity="SONAcl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    public function __construct($options = array()) {
        /*
          $hydrator = new Hydrator\ClassMethods;
          $hydrator->hydrate($opton, $this);
         */
        (new Hydrator\ClassMethods())->hydrate($options, $this);

        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
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

    public function setResources($resources) {
        $this->resources = $resources;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function toArray() {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'role' => $this->role->getId(),
            'resource' => $this->resources->getId()
        );
    }

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

    public function getResources() {
        return $this->resources;
    }

    public function getRole() {
        return $this->role;
    }

}
