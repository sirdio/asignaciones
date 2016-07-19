<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Directivo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DirectivoRepository")
 * 
 * 
 */

class Directivo  extends Usuariovotante 
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
    private $cargo;    
	
    /**
     * @var string
     *
     * @ORM\Column(name="emaild", type="string", length=150)
     * 
     */    
    private $emaild;
	
    /**
    * @ORM\Column(name="teld", type="string", length=30)
    */    
    private $teld;	
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    
        return $this;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

	    public function setEmaild($emaild)
    {
        $this->emaild = $emaild;
    
        return $this;
    }

    public function getEmaild()
    {
        return $this->emaild;
    }

    public function setTeld($teld)
    {
        $this->teld = $teld;
    
        return $this;
    }

    public function getTeld()
    {
        return $this->Teld;
    }
  
}