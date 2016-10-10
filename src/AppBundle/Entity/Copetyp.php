<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Copetyp")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CopetypRepository")
 * 
 * 
 */

class Copetyp  extends Usuariovotante 
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
     * @ORM\Column(name="cargo", type="string", length=150)
     * 
     */    
    private $cargocop;    

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Configuracion")
    * @ORM\JoinColumn(name="idconfig", referencedColumnName="id")
    */
    private $configuracion;    


//////////////////////////////////////
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

//////////////////////////////////////
   public function setCargocop($cargocop)
    {
        $this->cargocop = $cargocop;
    
        return $this;
    }

    public function getCargocop()
    {
        return $this->cargocop;
    }

//////////////////////////////////////
    /**
     * Set configuracion
     *
     * @param \appBundle\Entity\Configuracion $configuracion
     * @return Copetyp
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