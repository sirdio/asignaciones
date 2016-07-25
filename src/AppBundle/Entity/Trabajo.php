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
     * @var string
     *
     * @ORM\Column(name="descproyecto", type="string", length=300)
     * 
     */    
    private $descproyecto;
    /**
    * @ORM\Column(name="pavproyecto", type="string", length=250)
    */    
    private $pavproyecto;
    /**
    * @ORM\Column(name="dpwproyecto", type="string", length=150)
    */
    private $dpwproyecto;  

    /**
    * @ORM\Column(name="aemproyecto", type="string", length=150)
    */
    private $aemproyecto;
    /**
    * @ORM\Column(name="cantvoto", type="integer")
    */
    private $cantvoto;
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
        

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

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
    public function setDescproyecto($descproyecto)
    {
        $this->descproyecto = $descproyecto;
    
        return $this;
    }

    public function getDescproyecto()
    {
        return $this->descproyecto;
    }
//////////////////////////////////////
    public function setPavproyecto($pavproyecto)
    {
        $this->pavproyecto = $pavproyecto;
    
        return $this;
    }

    public function getPavproyecto()
    {
        return $this->pavproyecto;
    }   
//////////////////////////////////////
    public function setDpwproyecto($dpwproyecto)
    {
        $this->dpwproyecto = $dpwproyecto;
    
        return $this;
    }

    public function getDpwproyecto()
    {
        return $this->dpwproyecto;
    }    
//////////////////////////////////////
    public function setAemproyecto($aemproyecto)
    {
        $this->aemproyecto = $aemproyecto;
    
        return $this;
    }

    public function getAemproyecto()
    {
        return $this->aemproyecto;
    }    
//////////////////////////////////////
    public function setCantvoto($cantvoto)
    {
        $this->cantvoto = $cantvoto;
    
        return $this;
    }

    public function getCantvoto()
    {
        return $this->cantvoto;
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

      
}