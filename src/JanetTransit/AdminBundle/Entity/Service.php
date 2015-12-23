<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Poste", mappedBy="service", cascade={"persist"})
     */
    private $postes;


    /**
     * @ORM\OneToMany(targetEntity="Employe", mappedBy="services", cascade={"persist"})
     */
    private $employes;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;


    public function __construct()
    {
        $this->postes   = new ArrayCollection();
        $this->employes = new ArrayCollection();
    }

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
     * @return boolean
     */
    public function isDel()
    {
        return $this->del;
    }

    /**
     * @param boolean $del
     */
    public function setDel($del)
    {
        $this->del = $del;
    }



    /**
     * @return mixed
     */
    public function getEmployes()
    {
        return $this->employes;
    }

    /**
     * @param mixed $employes
     */
    public function setEmployes($employes)
    {
        $this->employes = $employes;
    }



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Service
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
    public function getPostes()
    {
        return $this->postes;
    }

    /**
     * @param mixed $postes
     */
    public function setPostes($postes)
    {
        $this->postes = $postes;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return Service
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

