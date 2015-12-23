<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\StockRepository")
 */
class Stock
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
     * @ORM\Column(name="materiel", type="string", length=255)
     */
    private $materiel;

    /**
     * @var float
     *
     * @ORM\Column(name="qteInitial", type="float")
     */
    private $qteInitial;

    /**
     * @var float
     *
     * @ORM\Column(name="qteStock", type="float")
     */
    private $qteStock;

    /**
     * @ORM\ManyToOne(targetEntity="TypeStock")
     */
    private $typeStock;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean")
     */
    private $del = 0;


    public function __toString(){
        return $this->materiel;
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
    public function getTypeStock()
    {
        return $this->typeStock;
    }

    /**
     * @param mixed $typeStock
     */
    public function setTypeStock($typeStock)
    {
        $this->typeStock = $typeStock;
    }


    /**
     * Set materiel
     *
     * @param string $materiel
     *
     * @return Stock
     */
    public function setMateriel($materiel)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get materiel
     *
     * @return string
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Set qteInitial
     *
     * @param float $qteInitial
     *
     * @return Stock
     */
    public function setQteInitial($qteInitial)
    {
        $this->qteInitial = $qteInitial;

        return $this;
    }

    /**
     * Get qteInitial
     *
     * @return float
     */
    public function getQteInitial()
    {
        return $this->qteInitial;
    }

    /**
     * Set qteStock
     *
     * @param float $qteStock
     *
     * @return Stock
     */
    public function setQteStock($qteStock)
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    /**
     * Get qteStock
     *
     * @return float
     */
    public function getQteStock()
    {
        return $this->qteStock;
    }
}

