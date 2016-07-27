<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Docente")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DocenteRepository")
 * 
 * 
 */

class Docente  extends Usuariovotante 
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="espacioc", type="string", length=150)
     * 
     */    
    private $espacioc;    

	/**
     * @var string
     *
     * @ORM\Column(name="especialidadd", type="string", length=150)
     * 
     */    
    private $especialidadd;
	
    /**
     * @var string
     *
     * @ORM\Column(name="emaildoc", type="string", length=150)
     * 
     */    
    private $emaildoc;
	
    /**
    * @ORM\Column(name="teldoc", type="string", length=30)
    */    
    private $teldoc;

    /**
    * @ORM\Column(name="niveldoc", type="string", length=30)
    */    
    private $niveldoc;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Presentacion")
    * @ORM\JoinColumn(name="idpres", referencedColumnName="id")
    */
    private $presentacion;      

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Configuracion")
    * @ORM\JoinColumn(name="idconfig", referencedColumnName="id")
    */
    private $configuracion; 
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
//////////////////////////////////////////////
   public function setEspacioc($espacioc)
    {
        $this->espacioc = $espacioc;
    
        return $this;
    }

    public function getEspacioc()
    {
        return $this->espacioc;
    }
//////////////////////////////////////////////
   public function setEspecialidadd($especialidadd)
    {
        $this->especialidadd = $especialidadd;
    
        return $this;
    }

    public function getEspecialidadd()
    {
        return $this->especialidadd;
    }
//////////////////////////////////////////////	
    public function setEmaildoc($emaildoc)
    {
        $this->emaildoc = $emaildoc;
    
        return $this;
    }

    public function getEmaildoc()
    {
        return $this->emaildoc;
    }
//////////////////////////////////////////////
    public function setTeldoc($teldoc)
    {
        $this->teldoc = $teldoc;
    
        return $this;
    }

    public function getTeldoc()
    {
        return $this->teldoc;
    }

/////////////////////////////////////////////
    public function setNiveldoc($niveldoc)
    {
        $this->niveldoc = $niveldoc;
    
        return $this;
    }

    public function getNiveldoc()
    {
        return $this->niveldoc;
    }
    
//////////////////////////////////////
    /**
     * Set presentacion
     *
     * @param \appBundle\Entity\Presentacion $presentacion
     * @return Docente
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
    /**
     * Set configuracion
     *
     * @param \appBundle\Entity\Configuracion $configuracion
     * @return Docente
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