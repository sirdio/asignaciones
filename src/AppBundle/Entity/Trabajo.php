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
* @ORM\Table(name="Trabajo")
* @ORM\Entity(repositoryClass="AppBundle\Entity\TrabajoRepository") 
* 
*/

class Trabajo
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
     * @ORM\Column(name="nombproyecto", type="string", length=250)
     * 
     */    
    private $nombproyecto;    
    /**
    * @ORM\Column(name="cvmencion", type="integer")
    */
    private $cvmencion;

    /**
    * @ORM\Column(name="cvdestacado", type="integer")
    */
    private $cvdestacado;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Encargado")
    * @ORM\JoinColumn(name="idenc", referencedColumnName="id")
    */
    private $encargado;
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Escuela")
    * @ORM\JoinColumn(name="idesc", referencedColumnName="id")
    */
    private $escuela;    
    /**
    * @ORM\Column(name="niveltrab", type="string", length=30)
    */    
    private $niveltrab;  
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;    
    /**
    * @ORM\Column(name="estado", type="boolean")
    */
    private $estado;
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Configuracion")
    * @ORM\JoinColumn(name="idconfig", referencedColumnName="id")
    */
    private $configuracion; 
    /**
    * @ORM\Column(name="stand", type="integer")
    */
    private $stand;    
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
//////////////////////////////////////
    public function setNombproyecto($nombproyecto)
    {
        $this->nombproyecto = $nombproyecto;
    
        return $this;
    }

    public function getNombproyecto()
    {
        return $this->nombproyecto;
    }
    
//////////////////////////////////////

    public function setCvmencion($cvmencion)
    {
        $this->cvmencion = $cvmencion;
    
        return $this;
    }

    public function getCvmencion()
    {
        return $this->cvmencion;
    }    
//////////////////////////////////////
    public function setCvdestacado($cvdestacado)
    {
        $this->cvdestacado = $cvdestacado;
    
        return $this;
    }

    public function getCvdestacado()
    {
        return $this->cvdestacado;
    }    
//////////////////////////////////////
    /**
     * Set encargado
     *
     * @param \appBundle\Entity\Encargado $encargado
     * @return Trabajo
     */
    public function setEncargado(\AppBundle\Entity\Encargado $encargado = null)
    {
        $this->encargado = $encargado;
    
        return $this;
    }
    
    /**
     * Get encargado
     *
     * @return \appBundle\Entity\Encargado
     */
    public function getEncargado()
    {
        return $this->encargado;
    }
//////////////////////////////////////
    /**
     * Set escuela
     *
     * @param \appBundle\Entity\Escuela $escuela
     * @return Trabajo
     */
    public function setEscuela(\AppBundle\Entity\Escuela $escuela = null)
    {
        $this->escuela = $escuela;
    
        return $this;
    }

    /**
     * Get escuela
     *
     * @return \appBundle\Entity\Escuela
     */
    public function getEscuela()
    {
        return $this->escuela;
    }
//////////////////////////////////////
    public function setNiveltrab($niveltrab)
    {
        $this->niveltrab = $niveltrab;
    
        return $this;
    }

    public function getNiveltrab()
    {
        return $this->niveltrab;
    } 
//////////////////////////////////////
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }
//////////////////////////////////////
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }   
    /**
     * Set configuracion
     *
     * @param \appBundle\Entity\Configuracion $configuracion
     * @return Trabajo
     */
    public function setConfiguracion(\AppBundle\Entity\Configuracion $configuracion = null)
    {
        $this->configuracion = $configuracion;
    
        return $this;
    }

    /**
     * Get configuracion
     *
     * @return \appBundle\Entity\Configuracion
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }
          //////////////////////////////////////
    public function setStand($stand)
    {
        $this->stand = $stand;
    
        return $this;
    }

    public function getStand()
    {
        return $this->stand;
    }
}