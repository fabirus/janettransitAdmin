<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\TypeStockRepository")
 */
class TypeStock
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
     * @return TypeStock
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
}

