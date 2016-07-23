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
     * @var string
     *
     * @ORM\Column(name="emaile", type="string", length=150)
     * 
     */    
    private $emaile;
	
    /**
    * @ORM\Column(name="tele", type="string", length=30)
    */    
    private $tele;
    
    /**
    * @ORM\Column(name="diconf", type="integer")
    */    
    private $idconf;
    
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

    public function setEmaile($emaile)
    {
        $this->emaile = $emaile;
    
        return $this;
    }

    public function getEmaile()
    {
        return $this->emaile;
    }

    public function setTele($tele)
    {
        $this->tele = $tele;
    
        return $this;
    }

    public function getTele()
    {
        return $this->Tele;
    }

    public function setIdconf($idconf)
    {
        $this->idconf = $idconf;
    
        return $this;
    }

    public function getIdconf()
    {
        return $this->idconf;
    }	
}