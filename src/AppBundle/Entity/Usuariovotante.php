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
* @ORM\Table(name="Usuariovotante")
* @ORM\Entity(repositoryClass="AppBundle\Entity\UsuariovotanteRepository") 
* @ORM\DiscriminatorMap({"usuariovotante" = "Usuariovotante","directivo" = "Directivo", "encargado" = "Encargado", "estudiante" = "Estudiante", "docente" = "Docente", "copetyp" = "Copetyp"})
* @ORM\InheritanceType("JOINED")
* @ORM\DiscriminatorColumn(name="tipo", type="string")
*/

class Usuariovotante
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
    * @ORM\Column(name="tipovot", type="string", length=10)
    */
    private $tipovot;  
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function __construct()
    {
        $this->isActive = true;
    }    

    public function getId()
    {
        return $this->id;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    public function getDni()
    {
        return $this->dni;
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

    public function setTipovot( $tipovot)
    {
        $this->tipovot = $tipovot;
    
        return $this;
    }

    public function getTipovot()
    {
        return $this->tipovot;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }
}