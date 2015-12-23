<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVoiture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\TypeVoitureRepository")
 */
class TypeVoiture
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="faClass", type="string", length=255)
     */
    private $faClass;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="Voiture", mappedBy="typeVoiture", cascade={"persist", "remove"})
     */
    private $voiture;

    public function __toString(){
        return $this->nom;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFaClass()
    {
        return $this->faClass;
    }

    /**
     * @param string $faClass
     */
    public function setFaClass($faClass)
    {
        $this->faClass = $faClass;
    }



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return TypeVoiture
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getVoiture()
    {
        return $this->voiture;
    }

    /**
     * @param mixed $voiture
     */
    public function setVoiture($voiture)
    {
        $this->voiture = $voiture;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return TypeVoiture
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

