<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint\NotBlank;
use Symfony\Component\Validator\Constraint\NotBlankValidator;
use Symfony\Component\Validator\Constraint\NotNull;

/**
*
* @ORM\Entity
* @ORM\Table(name="Users")
* @ORM\Entity(repositoryClass="AppBundle\Entity\UsersRepository") 
* 
*/

class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
    * @var string
    *
    * @ORM\Column(name="correo", type="string", length=250)
    */    
    private $correo;    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=250)
     * 
     */    
    private $username;
    /**
    * @ORM\Column(name="password", type="string", length=250)
    */    
    private $password;


    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }
/////////////////////////////////////////////////////
    public function setCorreo( $correo)
    {
        $this->correo = $correo;
    
        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }
//////////////////////////////////////////////
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
//////////////////////////////////////////////
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}