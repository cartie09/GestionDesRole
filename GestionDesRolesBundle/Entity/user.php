<?php

namespace boxiweb\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/** 
 * user
 *
 * @ORM\Table(name="user") 
 * @UniqueEntity(fields="usernameCanonical", errorPath="username", message="fos_user.username.already_used", groups={"Default", "Registration", "Profile"})
 * @UniqueEntity(fields="emailCanonical", errorPath="email", message="fos_user.email.already_used", groups={"Default", "Registration", "Profile"})
 * @ORM\Entity(repositoryClass="boxiweb\UserBundle\Repository\userRepository")
 */
class user extends BaseUser {

/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\ManyToMany(targetEntity="boxiweb\UserBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
 
    /**
     * @ORM\Column(type="integer", length=6, options={"default":0})
     */
    protected $loginCount = 0;
 
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $firstLogin;
    
/**
* @var string $family_name
*
* @ORM\Column(name="family_name", type="string", length=255, nullable=true)
*/
    private $family_name;
//
    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $last_name;
//
    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
//
    /**
     * @var string $prenom
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
//
    /**
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $first_name;
//
    /**
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=45, nullable=true)
     */
    private $tel;
//
    /**
     * @var \DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;
//
    /**
     * @var \DateTime $lastActivity
     *
     * @ORM\Column(name="lastActivity", type="datetime")
     */
    protected $lastActivity;

    
    
    
    
    public function getId() {
        return $this->id;
    }

    public function getFamily_name() {
        return $this->family_name;
    }

    public function getLast_name() {
        return $this->last_name;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getFirst_name() {
        return $this->first_name;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getLastActivity() {
        return $this->lastActivity;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFamily_name($family_name) {
        $this->family_name = $family_name;
    }

    public function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    public function setLastActivity(\DateTime $lastActivity) {
        $this->lastActivity = $lastActivity;
    }
    public function getGroups() {
        return $this->groups;
    }

            
    
    
 
    public function __construct() {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }
 
    /**
     * Set loginCount
     *
     * @param integer $loginCount
     *
     * @return User
     */
    public function setLoginCount($loginCount) {
        $this->loginCount = $loginCount;
        return $this;
    }
 
    /**
     * Get loginCount
     *
     * @return integer
     */
    public function getLoginCount() {
        return $this->loginCount;
    }
 
    /**
     * Set firstLogin
     *
     * @param \DateTime $firstLogin
     *
     * @return User
     */
    public function setFirstLogin($firstLogin) {
        $this->firstLogin = $firstLogin;
        return $this;
    }
 
    /**
     * Get firstLogin
     *
     * @return \DateTime
     */
    public function getFirstLogin() {
        return $this->firstLogin;
    }
 
    function getEnabled() {
        return $this->enabled;
    }
 
    function getLocked() {
        return $this->locked;
    }
 
    function getExpired() {
        return $this->expired;
    }
 
    function getExpiresAt() {
        return $this->expiresAt;
    }
 
    function getCredentialsExpired() {
        return $this->credentialsExpired;
    }
 
    function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }
 
    function setSalt($salt) {
        $this->salt = $salt;
    }
 
    public function setPassword($password) {
        if ($password !== null)
            $this->password = $password;
        return $this;
    }
 
    function setGroups(Collection $groups = null) {
        if ($groups !== null)
            $this->groups = $groups;
    }
 
    public function setRoles(array $roles = array()) {
        $this->roles = array();
        foreach ($roles as $role)
            $this->addRole($role);
        return $this;
    }
 
    public function hasGroup($name = '') {
        return in_array($name, $this->getGroupNames());
    }
}