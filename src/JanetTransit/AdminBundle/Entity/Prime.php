<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prime
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PrimeRepository")
 */
class Prime
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
     * @ORM\Column(name="periode", type="string", length=255)
     */
    private $periode;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="prime")
     */
    private $employe;

    public function __toString(){
        return $this->employe;

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
     * Set periode
     *
     * @param string $periode
     *
     * @return Prime
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * Get periode
     *
     * @return string
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param boolean $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }



    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return Prime
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Prime
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }
}

