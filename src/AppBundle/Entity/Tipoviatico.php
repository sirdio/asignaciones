<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint\NotBlank;
use Symfony\Component\Validator\Constraint\NotBlankValidator;
use Symfony\Component\Validator\Constraint\NotNull;

/**
*
* @ORM\Entity
* @ORM\Table(name="Tipoviatico")
* @ORM\Entity(repositoryClass="AppBundle\Entity\TipoviaticoRepository") 
* 
*/

class Tipoviatico
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
    * @ORM\Column(name="desc", type="string", length=20)
    */    
    private $desc;    
    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function getId()
    {
        return $this->id;
    }

    public function setDesc($desc)
    {
        $this->desc = $desc;
    
        return $this;
    }

    public function getDesc()
    {
        return $this->desc;
    }
    
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }    

}