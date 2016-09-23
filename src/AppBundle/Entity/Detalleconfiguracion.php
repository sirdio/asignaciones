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
* @ORM\Table(name="Detalleconfiguracion")
* @ORM\Entity(repositoryClass="AppBundle\Entity\DetalleconfiguracionRepository") 
* 
*/

class Detalleconfiguracion
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
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Configuracion")
    * @ORM\JoinColumn(name="idconf", referencedColumnName="id")
    */
    private $configuracion;
    /**
    * @ORM\Column(name="jurisdiccion", type="string", length=15)
    */    
    private $juris;    
    /**
    * @ORM\Column(name="cantcbs", type="integer")
    */    
    private $cantcbs;    
    /**
     *
     * @ORM\Column(name="cantcss", type="integer")
     * 
     */    
    private $cantcss;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    public function getId()
    {
        return $this->id;
    }
////////////////////////////////////////////////////////
    public function setJuris($juris)
    {
        $this->juris = $juris;
    
        return $this;
    }

    public function getJuris()
    {
        return $this->juris;
    }
//////////////////////////////////////////////////
    public function setCantcbs($cantcbs)
    {
        $this->cantcbs = $cantcbs;
    
        return $this;
    }

    public function getCantcbs()
    {
        return $this->cantcbs;
    }
//////////////////////////////////////////////////
    public function setCantcss($cantcss)
    {
        $this->cantcss = $cantcss;
    
        return $this;
    }

    public function getCantcss()
    {
        return $this->cantcss;
    }   
////////////////////////////////////////////
    /**
     * Set configuracio
     *
     * @param \appBundle\Entity\Configuracion $configuracion
     * @return Detalleconfiguracion
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

}