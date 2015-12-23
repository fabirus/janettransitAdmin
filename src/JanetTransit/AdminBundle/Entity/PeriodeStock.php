<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PeriodeStockRepository")
 */
class PeriodeStock
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
     * @ORM\Column(name="datePeriode", type="string", length=255)
     */
    private $datePeriode;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean")
     */
    private $del = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Stock")
     */
    private $stock;


    public function __toString(){
        return $this->datePeriode;
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
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Set datePeriode
     *
     * @param string $datePeriode
     *
     * @return PeriodeStock
     */
    public function setDatePeriode($datePeriode)
    {
        $this->datePeriode = $datePeriode;

        return $this;
    }

    /**
     * Get datePeriode
     *
     * @return string
     */
    public function getDatePeriode()
    {
        return $this->datePeriode;
    }
}

