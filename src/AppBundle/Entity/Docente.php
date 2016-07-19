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
     * @ORM\Column(name="especioc", type="string", length=150)
     * 
     */    
    private $especioc;    

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
    * @ORM\Column(name="maildoc", type="string", length=30)
    */    
    private $maildoc;
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setEspecioc($especioc)
    {
        $this->especioc = $especioc;
    
        return $this;
    }

    public function getEspecioc()
    {
        return $this->especioc;
    }

   public function setEspecialidadd($especialidadd)
    {
        $this->especialidadd = $especialidadd;
    
        return $this;
    }

    public function getEspecialidadd()
    {
        return $this->especialidadd;
    }
	
    public function setMaildoc($maildoc)
    {
        $this->maildoc = $maildoc;
    
        return $this;
    }

    public function getMaildoc()
    {
        return $this->maildoc;
    }

    public function setTeldoc($teldoc)
    {
        $this->teldoc = $teldoc;
    
        return $this;
    }

    public function getTeldoc()
    {
        return $this->Teldoc;
    }
	
}