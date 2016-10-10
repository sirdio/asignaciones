<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\Common\Collections\ArrayCollection;
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
    * @ORM\Column(name="ctvcbs", type="integer")
    */    
    private $ctvcbs;    
    /**
    * @ORM\Column(name="ctvcss", type="integer")
    */    
    private $ctvcss; 
    /**
    * @ORM\Column(name="ctvfp", type="integer")
    */    
    private $ctvfp;    
    /**
    * @ORM\Column(name="ctvts", type="integer")
    */    
    private $ctvts; 
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function __construct()
    {

        $this->isActive = false;
    } 
    
    public function getId()
    {
        return $this->id;
    }
/////////////////////////////////////////////////////
    public function setCtvcbs($ctvcbs)
    {
        $this->ctvcbs = $ctvcbs;
    
        return $this;
    }

    public function getCtvcbs()
    {
        return $this->ctvcbs;
    }

/////////////////////////////////////////
    public function setCtvcss($ctvcss)
    {
        $this->ctvcss = $ctvcss;
    
        return $this;
    }

    public function getCtvcss()
    {
        return $this->ctvcss;
    }

/////////////////////////////////////////
    public function setCtvfp($ctvfp)
    {
        $this->ctvfp = $ctvfp;
    
        return $this;
    }

    public function getCtvfp()
    {
        return $this->ctvfp;
    }

/////////////////////////////////////////
    public function setCtvts($ctvts)
    {
        $this->ctvts = $ctvts;
    
        return $this;
    }

    public function getCtvts()
    {
        return $this->ctvts;
    }

/////////////////////////////////////////    
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