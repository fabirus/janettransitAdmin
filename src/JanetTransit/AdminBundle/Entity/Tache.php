<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tache
 *
 * @ORM\Table(name="tache")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\TacheRepository")
 */
class Tache
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
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="explication", type="text")
     */
    private $explication;


    /**
     * @ORM\ManyToOne(targetEntity="Taf", inversedBy="tache")
     */
    private $taf;

    /**
     * @ORM\ManyToOne(targetEntity="Voiture")
     */
    private $voiture;

    /**
     * @ORM\ManyToMany(targetEntity="Employe", inversedBy="tache")
     */
    private $employe;

//    public function __construct()
//    {
//        $this->employe = new ArrayCollection();
//    }

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Tache
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
     * @return mixed
     */
    public function getEmploye()
    {
        return $this->employe;
    }

    /**
     * @param mixed $employe
     */
    public function setEmploye($employe)
    {
        $this->employe = $employe;
    }



    /**
     * @return mixed
     */
    public function getTaf()
    {
        return $this->taf;
    }

    /**
     * @param mixed $taf
     */
    public function setTaf($taf)
    {
        $this->taf = $taf;
    }



    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Tache
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set explication
     *
     * @param string $explication
     *
     * @return Tache
     */
    public function setExplication($explication)
    {
        $this->explication = $explication;

        return $this;
    }

    /**
     * Get explication
     *
     * @return string
     */
    public function getExplication()
    {
        return $this->explication;
    }
}

