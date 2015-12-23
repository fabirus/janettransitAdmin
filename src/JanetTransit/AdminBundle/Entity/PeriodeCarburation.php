<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PeriodeCarburation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PeriodeCarburationRepository")
 */
class PeriodeCarburation
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
     * @ORM\Column(name="dateCarburation", type="string", length=255)
     */
    private $dateCarburation;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;


    /**
     * @ORM\OneToMany(targetEntity="Carburation", mappedBy="periodeCarburation", cascade={"persist", "remove"})
     */
    private $carburation;


    public function __toString(){
        return $this->dateCarburation;

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
     * Set dateCarburation
     *
     * @param string $dateCarburation
     *
     * @return PeriodeCarburation
     */
    public function setDateCarburation($dateCarburation)
    {
        $this->dateCarburation = $dateCarburation;

        return $this;
    }

    /**
     * Get dateCarburation
     *
     * @return string
     */
    public function getDateCarburation()
    {
        return $this->dateCarburation;
    }

    /**
     * @return mixed
     */
    public function getCarburation()
    {
        return $this->carburation;
    }

    /**
     * @param mixed $carburation
     */
    public function setCarburation($carburation)
    {
        $this->carburation = $carburation;
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


}

