<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use JsonSerializable;

/**
 * @Entity
 * @Table(name="user")
 */
class User  implements JsonSerializable{
     /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $password;

    function getId() {
        return $this->id;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'firstname' => $this->firstname,
            'email'=> $this->email,
        );
    }
}
