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
    * @ORM\Column(name="totalvotos", type="integer")
    */    
    private $totalvotos;    
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
    public function setTotalvotos($totalvotos)
    {
        $this->totalvotos = $totalvotos;
    
        return $this;
    }

    public function getTotalvotos()
    {
        return $this->totalvotos;
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