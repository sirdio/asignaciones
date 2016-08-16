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
* @ORM\Table(name="Viatico")
* @ORM\Entity(repositoryClass="AppBundle\Entity\ViaticoRepository") 
* 
*/

class Viatico
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
    * @ORM\Column(name="dniv", type="string", length=10)
    */    
    private $dniv;    
    /**
    * @ORM\Column(name="descv", type="string", length=20)
    */    
    private $descv;
    /**
    * @ORM\Column(name="fechav", type="string", length=10)
    */    
    private $fechav;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }

    public function setDniv($dniv)
    {
        $this->dniv = $dniv;
    
        return $this;
    }

    public function getDniv()
    {
        return $this->dniv;
    }
    
    public function setDescv($descv)
    {
        $this->descv = $descv;
    
        return $this;
    }

    public function getDescv()
    {
        return $this->descv;
    }
    
    public function setFechav($fechav)
    {
        $this->fechav = $fechav;
    
        return $this;
    }

    public function getFechav()
    {
        return $this->fechav;
    }
    

}