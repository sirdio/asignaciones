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
     * @var string
     *
     * @ORM\Column(name="emailcop", type="string", length=150)
     * 
     */    
    private $emailcop;
	
    /**
    * @ORM\Column(name="telcop", type="string", length=30)
    */    
    private $telcop;	
    
   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setCargocop($cargocop)
    {
        $this->cargocop = $cargocop;
    
        return $this;
    }

    public function getCargocop()
    {
        return $this->cargocop;
    }

	    public function setEmailcop($emailcop)
    {
        $this->emailcop = $emailcop;
    
        return $this;
    }

    public function getEmailcop()
    {
        return $this->emailcop;
    }

    public function setTelcop($telcop)
    {
        $this->telcop = $telcop;
    
        return $this;
    }

    public function getTelcop()
    {
        return $this->Telcop;
    }
  
}