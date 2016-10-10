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
* @ORM\Table(name="Escuela")
* @ORM\Entity(repositoryClass="AppBundle\Entity\EscuelaRepository") 
* 
*/

class Escuela
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
    * @ORM\Column(name="cue", type="string", length=10)
    */    
    private $cue;    
    /**
     * @var string
     *
     * @ORM\Column(name="nombesc", type="string", length=150)
     * 
     */    
    private $nombesc;
    /**
    * @ORM\Column(name="jurisdiccion", type="string", length=150)
    */    
    private $jurisdiccion;
    /**
    * @ORM\Column(name="localidad", type="string", length=150)
    */
    private $localidad;  

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }

    public function setCue($cue)
    {
        $this->cue = $cue;
    
        return $this;
    }

    public function getCue()
    {
        return $this->cue;
    }

    public function setNombesc($nombesc)
    {
        $this->nombesc = $nombesc;
    
        return $this;
    }

    public function getNombesc()
    {
        return $this->nombesc;
    }

    public function setJurisdiccion($jurisdiccion)
    {
        $this->jurisdiccion = $jurisdiccion;
    
        return $this;
    }

    public function getJurisdiccion()
    {
        return $this->jurisdiccion;
    }   

    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    
        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }    
    
}