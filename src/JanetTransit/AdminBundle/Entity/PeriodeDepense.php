<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeDepense
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PeriodeDepenseRepository")
 */
class PeriodeDepense
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
     * @ORM\Column(name="dateDepense", type="string", length=255)
     */
    private $dateDepense;


    /**
     * @ORM\ManyToOne(targetEntity="TypeDepense")
     */
    private $typeDepense;

    /**
     * @ORM\ManyToOne(targetEntity="ContratEts")
     */
    private $contrat;

    /**
     * @ORM\OneToMany(targetEntity="Depense", mappedBy="periodeDepense", cascade={"persist", "remove"})
     */
    private $depense;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean")
     */
    private $del = 0;



    public function __toString(){
        return $this->dateDepense;
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
     * Set dateDepense
     *
     * @param string $dateDepense
     *
     * @return PeriodeDepense
     */
    public function setDateDepense($dateDepense)
    {
        $this->dateDepense = $dateDepense;

        return $this;
    }

    /**
     * Get dateDepense
     *
     * @return string
     */
    public function getDateDepense()
    {
        return $this->dateDepense;
    }

    /**
     * @return mixed
     */
    public function getDepense()
    {
        return $this->depense;
    }

    /**
     * @param mixed $depense
     */
    public function setDepense($depense)
    {
        $this->depense = $depense;
    }



    /**
     * @return mixed
     */
    public function getTypeDepense()
    {
        return $this->typeDepense;
    }

    /**
     * @param mixed $typeDepense
     */
    public function setTypeDepense($typeDepense)
    {
        $this->typeDepense = $typeDepense;
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




}

