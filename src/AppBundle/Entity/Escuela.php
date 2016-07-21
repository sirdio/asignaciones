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
    * @ORM\Column(name="departamento", type="string", length=150)
    */
    private $departamento;  

    /**
    * @ORM\Column(name="localidad", type="string", length=150)
    */
    private $localidad;
    /**
    * @ORM\Column(name="domicilio", type="string", length=200)
    */
    private $domicilio;
    /**
    * @ORM\Column(name="telefono", type="string", length=15)
    */
    private $telefono;
    /**
    * @ORM\Column(name="emailesc", type="string", length=200)
    */
    private $emailesc;    
    /**
    * @ORM\Column(name="ambitogestion", type="string", length=150)
    */
    private $ambitogestion;        

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

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    
        return $this;
    }

    public function getDepartamento()
    {
        return $this->departamento;
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

    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    
        return $this;
    }

    public function getDomicilio()
    {
        return $this->domicilio;
    }    

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }    

    public function setEmailesc($emailesc)
    {
        $this->emailesc = $emailesc;
    
        return $this;
    }

    public function getEmailesc()
    {
        return $this->emailesc;
    }    
    
    public function setAmbitogestion($ambitogestion)
    {
        $this->ambitogestion = $ambitogestion;
    
        return $this;
    }

    public function getAmbitogestion()
    {
        return $this->ambitogestion;
    }      
}