<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Encargado")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EncargadoRepository")
 * 
 * 
 */

class Encargado  extends Usuariovotante 
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
     * @ORM\Column(name="materiadic", type="string", length=150)
     * 
     */    
    private $materiadic;   
    
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

   public function setMateriadic($materiadic)
    {
        $this->materiadic = $materiadic;
    
        return $this;
    }

    public function getMateriadic()
    {
        return $this->materiadic;
    }

    /**
     * Set configuracion
     *
     * @param \appBundle\Entity\Configuracion $configuracion
     * @return Encargado
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