<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint\NotBlank;
use Symfony\Component\Validator\Constraint\NotBlankValidator;
use Symfony\Component\Validator\Constraint\NotNull;

/**
*
* @ORM\Entity
* @ORM\Table(name="Jurisdiccion")
* @ORM\Entity(repositoryClass="AppBundle\Entity\JurisdiccionRepository") 
* 
*/

class Jurisdiccion
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
     * @var string
     *
     * @ORM\Column(name="nomjuris", type="string", length=15)
     * 
     */    
    private $nomjuris;    

    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    public function getId()
    {
        return $this->id;
    }
//////////////////////////////////////
    public function setNomjuris($nomjuris)
    {
        $this->nomjuris = $nomjuris;
    
        return $this;
    }

    public function getNomjuris()
    {
        return $this->nomjuris;
    }
}