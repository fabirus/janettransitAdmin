<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeFacture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PeriodeFactureRepository")
 */
class PeriodeFacture
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
     * @ORM\Column(name="dateFacture", type="string", length=255)
     */
    private $dateFacture;

    /**
     * @ORM\ManyToOne(targetEntity="ContratEts")
     */
    private $contrat;

    /**
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="periodeFacture", cascade={"persist", "remove"})
     */
    private $facture;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean")
     */
    private $del = 0;

    public function __toString(){
        return $this->dateFacture;
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
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param mixed $contrat
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
    }

    /**
     * @return mixed
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * @param mixed $facture
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;
    }


    /**
     * Set dateFacture
     *
     * @param string $dateFacture
     *
     * @return PeriodeFacture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return string
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }
}

