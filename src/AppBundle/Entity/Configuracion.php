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
* @ORM\Table(name="Configuracion")
* @ORM\Entity(repositoryClass="AppBundle\Entity\ConfiguracionRepository") 
* 
*/

class Configuracion
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
    * @ORM\Column(name="cantcbsec", type="integer")
    */    
    private $cantcbsec;    
    /**
     *
     * @ORM\Column(name="cantcssec", type="integer")
     * 
     */    
    private $cantcssec;
    /**
    * @ORM\Column(name="cantfp", type="integer")
    */    
    private $cantfp;
    /**
    * @ORM\Column(name="cantts", type="integer")
    */
    private $cantts;  

    /**
    * @ORM\Column(name="cantexpped", type="integer")
    */
    private $cantexpped;

    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive; 

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function __construct()
    {
        $this->estado = false;
    } 
    
    public function getId()
    {
        return $this->id;
    }

    public function setCantcbsec($cantcbsec)
    {
        $this->cantcbsec = $cantcbsec;
    
        return $this;
    }

    public function getCantcbsec()
    {
        return $this->cantcbsec;
    }

    public function setCantcssec($cantcssec)
    {
        $this->cantcssec = $cantcssec;
    
        return $this;
    }

    public function getCantcssec()
    {
        return $this->cantcssec;
    }

    public function setCantfp($cantfp)
    {
        $this->cantfp = $cantfp;
    
        return $this;
    }

    public function getCantfp()
    {
        return $this->cantfp;
    }   

    public function setCantts($cantts)
    {
        $this->cantts = $cantts;
    
        return $this;
    }

    public function getCantts()
    {
        return $this->cantts;
    }    

    public function setCantexpped($cantexpped)
    {
        $this->cantexpped = $cantexpped;
    
        return $this;
    }

    public function getCantexpped()
    {
        return $this->cantexpped;
    } 

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

}