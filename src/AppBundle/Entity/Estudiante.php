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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setAniocursada($aniocursada)
    {
        $this->aniocursada = $aniocursada;
    
        return $this;
    }

    public function getAniocursada()
    {
        return $this->aniocursada;
    }

    public function setEspecialidada($especialidada)
    {
        $this->email = $especialidada;
    
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
	
}