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
* @ORM\Table(name="Asistencia")
* @ORM\Entity(repositoryClass="AppBundle\Entity\AsistenciaRepository") 
* 
*/

class Asistencia
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
    * @ORM\Column(name="dniasist", type="string", length=15)
    */    
    private $dniasist;    
    /**
     * @var string
     *
     * @ORM\Column(name="fechaasist", type="string",  length=10)
     * 
     */    
    private $fechaasist;



    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }
/////////////////////////////////////////////////////
    public function setDniasist( $dniasist)
    {
        $this->dniasist = $dniasist;
    
        return $this;
    }

    public function getDniasist()
    {
        return $this->dniasist;
    }
//////////////////////////////////////////////
    public function setFechaasist($fechaasist)
    {
        $this->fechaasist = $fechaasist;
    
        return $this;
    }

    public function getFechaasist()
    {
        return $this->fechaasist;
    }

}