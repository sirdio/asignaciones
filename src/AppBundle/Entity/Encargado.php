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
     * @ORM\Column(name="cargo", type="string", length=150)
     * 
     */    
    private $cargo;    

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function setMatdic($matdic)
    {
        $this->matdic = $matdic;
    
        return $this;
    }

    public function getMatdic()
    {
        return $this->atdic;
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
	
}