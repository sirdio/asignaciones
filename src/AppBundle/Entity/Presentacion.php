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
* @ORM\Table(name="Presentacion")
* @ORM\Entity(repositoryClass="AppBundle\Entity\PresentacionRepository") 
* 
*/

class Presentacion
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
     * @ORM\Column(name="adpresentacion", type="string", length=10)
     * 
     */    
    private $adpresentacion;    
    /**
     * @var string
     *
     * @ORM\Column(name="catpresentacion", type="string", length=150)
     * 
     */    
    private $catpresentacion;
    /**
    * @var string
    * 
    * @ORM\Column(name="esppresentacion", type="string", length=500)
    */    
    private $esppresentacion;
    /**
    * @var string
    * 
    * @ORM\Column(name="pavpresentacion", type="string", length=150)
    */
    private $pavpresentacion;  

    /**
    * @var string
    * 
    * @ORM\Column(name="napresentacion", type="string", length=250)
    */
    private $napresentacion;
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Escuela")
    * @ORM\JoinColumn(name="idesc", referencedColumnName="id")
    */
    private $escuela;    
    /**
    * @ORM\Column(name="nivelpres", type="string", length=30)
    */    
    private $nivelpres;        
    /**
    * @ORM\Column(name="cantvoto", type="integer")
    */
    private $cantvoto;
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }
//////////////////////////////////////
    public function setAdpresentacion($adpresentacion)
    {
        $this->adpresentacion = $adpresentacion;
    
        return $this;
    }

    public function getAdpresentacion()
    {
        return $this->adpresentacion;
    }
//////////////////////////////////////
    public function setCatpresentacion($catpresentacion)
    {
        $this->catpresentacion = $catpresentacion;
    
        return $this;
    }

    public function getCatpresentacion()
    {
        return $this->catpresentacion;
    }
//////////////////////////////////////
    public function setEsppresentacion($esppresentacion)
    {
        $this->esppresentacion = $esppresentacion;
    
        return $this;
    }

    public function getEsppresentacion()
    {
        return $this->esppresentacion;
    }    
//////////////////////////////////////
    public function setPavpresentacion($pavpresentacion)
    {
        $this->pavpresentacion = $pavpresentacion;
    
        return $this;
    }

    public function getPavpresentacion()
    {
        return $this->pavpresentacion;
    }   
//////////////////////////////////////
    public function setNapresentacion($napresentacion)
    {
        $this->napresentacion = $napresentacion;
    
        return $this;
    }

    public function getNapresentacion()
    {
        return $this->napresentacion;
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
    public function setNivelpres($nivelpres)
    {
        $this->nivelpres = $nivelpres;
    
        return $this;
    }

    public function getNivelpres()
    {
        return $this->nivelpres;
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
    
}