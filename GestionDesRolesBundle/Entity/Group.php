<?php
// src/AppBundle/Entity/Group.php
 
namespace boxiweb\UserBundle\Entity;
 
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * @ORM\Entity(repositoryClass="boxiweb\UserBundle\Repository\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
   
/** 
 * 
 * * @ORM\ManyToMany(targetEntity="boxiweb\UserBundle\Entity\user", mappedBy="groups") * 
*/ 
     protected $users;


    /**
     * @var string $prename
     *
     * @ORM\Column(name="prename", type="string")
     */
    protected $prename;
    
    
     public function __construct($name = '') {
        $this->name = $name;
        $this->roles = array();
    }

    public function getId() {
        return $this->id;
    }

    public function getUsers() {
        return $this->users;
    }

    public function getPrename() {
        return $this->prename;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsers($users) {
        $this->users = $users;
    }

    public function setPrename($prename) {
        $this->prename = $prename;
    }

        
    public function __toString() {
    return $this->prename;
}

}


 