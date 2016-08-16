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
* @ORM\Table(name="Tipoviatico")
* @ORM\Entity(repositoryClass="AppBundle\Entity\TipoviaticoRepository") 
* 
*/

class Tipoviatico
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
    * @ORM\Column(name="desc", type="string", length=20)
    */    
    private $desc;
    /**
    * @ORM\Column(name="fecha", type="string", length=10)
    */    
    private $fecha;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

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
    
    public function setDesc($desc)
    {
        $this->desc = $desc;
    
        return $this;
    }

    public function getDesc()
    {
        return $this->desc;
    }
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    

}