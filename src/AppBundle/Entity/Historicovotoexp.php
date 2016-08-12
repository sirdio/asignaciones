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
* @ORM\Table(name="Historicovotoexp")
* @ORM\Entity(repositoryClass="AppBundle\Entity\HistoricovotoexpRepository") 
* 
*/

class Historicovotoexp
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
     * @ORM\Column(name="nombre", type="string", length=150)
     * 
     */    
    private $nombre;
    /**
    * @ORM\Column(name="apellido", type="string", length=150)
    */    
    private $apellido;
    /**
    * @ORM\Column(name="fecha", type="string", length=10)
    */    
    private $fecha;
    /**
    * @ORM\Column(name="hora", type="string", length=10)
    */    
    private $hora;    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Presentacion")
    * @ORM\JoinColumn(name="idpres", referencedColumnName="id")
    */
    private $presentacion;
       

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
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
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
     * Set presentacion
     *
     * @param \appBundle\Entity\Presentacion $presentacion
     * @return Historicovotoexp
     */
    public function setPresentacion(\AppBundle\Entity\Presentacion $presentacion = null)
    {
        $this->presentacion = $presentacion;
    
        return $this;
    }

    /**
     * Get presentacion
     *
     * @return \appBundle\Entity\Presentacion
     */
    public function getPresentacion()
    {
        return $this->presentacion;
    }
//////////////////////////////////////

}