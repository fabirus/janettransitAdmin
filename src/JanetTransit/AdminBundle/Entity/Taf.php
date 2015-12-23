<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taf
 *
 * @ORM\Table(name="taf")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\TafRepository")
 */
class Taf
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
     * @ORM\Column(name="dateTache", type="string", length=255)
     */
    private $dateTache;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     * @ORM\OneToMany(targetEntity="Tache", mappedBy="taf", cascade={"persist", "remove"})
     */
    private $tache;

    public function __toString(){
        return $this->dateTache;
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
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * @param mixed $tache
     */
    public function setTache($tache)
    {
        $this->tache = $tache;
    }

    /**
     * Set dateTache
     *
     * @param string $dateTache
     *
     * @return Taf
     */
    public function setDateTache($dateTache)
    {
        $this->dateTache = $dateTache;

        return $this;
    }

    /**
     * Get dateTache
     *
     * @return string
     */
    public function getDateTache()
    {
        return $this->dateTache;
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
     * Set description
     *
     * @param string $description
     *
     * @return Taf
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

