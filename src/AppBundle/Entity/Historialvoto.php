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
* @ORM\Table(name="Historialvoto")
* @ORM\Entity(repositoryClass="AppBundle\Entity\HistorialvotoRepository") 
* 
*/

class Historialvoto
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
    * @ORM\Column(name="dni", type="string", length=10)
    */    
    private $dni;    
    /**
     * @var string
     *
     * @ORM\Column(name="nembre", type="string", length=150)
     * 
     */    
    private $nembre;
    /**
    * @ORM\Column(name="apellido", type="string", length=150)
    */    
    private $apellido;
    /**
    * @ORM\Column(name="fecha", type="string", length=10)
    */    
    private $fecha;
    /**
    * @ORM\Column(name="hora",type="string", length=10)
    */    
    private $hora;    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trabajo")
    * @ORM\JoinColumn(name="idtrab", referencedColumnName="id")
    */
    private $trabajo;
       

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }
///////////////////////////////////////
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    public function getDni()
    {
        return $this->dni;
    }
///////////////////////////////////////
    public function setNembre($nembre)
    {
        $this->nembre = $nembre;
    
        return $this;
    }

    public function getNembre()
    {
        return $this->nembre;
    }
//////////////////////////////////////////
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }
///////////////////////////////////////
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
///////////////////////////////////////
    public function setHora($hora)
    {
        $this->hora = $hora;
    
        return $this;
    }

    public function getHora()
    {
        return $this->hora
        ;
    }    
//////////////////////////////////////
    /**
     * Set trabajo
     *
     * @param \appBundle\Entity\Trabajo $trabajo
     * @return Historialvoto
     */
    public function setTrabajo(\AppBundle\Entity\Trabajo $trabajo = null)
    {
        $this->trabajo = $trabajo;
    
        return $this;
    }

    /**
     * Get trabajo
     *
     * @return \appBundle\Entity\Trabajo
     */
    public function getTrabajo()
    {
        return $this->trabajo;
    }
//////////////////////////////////////

}