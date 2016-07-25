<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Estudiante")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EstudianteRepository")
 * 
 * 
 */

class Estudiante  extends Usuariovotante 
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
     * @ORM\Column(name="aniocursa", type="string", length=10)
     * 
     */    
    private $aniocursa;    

    /**
     * @var string
     *
     * @ORM\Column(name="especialidada", type="string", length=150)
     * 
     */    
    private $especialidada;
	
    /**
    * @ORM\Column(name="nivel", type="string", length=30)
    */    
    private $nivel;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trabajo")
    * @ORM\JoinColumn(name="idtrab", referencedColumnName="id")
    */
    private $trabajo;      
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setAniocursa($aniocursa)
    {
        $this->aniocursa = $aniocursa;
    
        return $this;
    }

    public function getAniocursa()
    {
        return $this->aniocursa;
    }

    public function setEspecialidada($especialidada)
    {
        $this->especialidada = $especialidada;
    
        return $this;
    }

    public function getEspecialidada()
    {
        return $this->especialidada;
    }

    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    
        return $this;
    }

    public function getNivel()
    {
        return $this->nivel;
    }
    
//////////////////////////////////////
    /**
     * Set trabajo
     *
     * @param \appBundle\Entity\Trabajo $trabajo
     * @return Estudiante
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
	
}