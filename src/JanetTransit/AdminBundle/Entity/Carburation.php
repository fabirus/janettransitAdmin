<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Carburation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\CarburationRepository")
 * @Vich\Uploadable
 */
class Carburation
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
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     *
     * @Vich\UploadableField(mapping="file_carburation", fileNameProperty="carburationFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $carburationFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $carburationFileName;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="carburation")
     */
    private $employe;


    /**
     * @ORM\ManyToOne(targetEntity="PeriodeCarburation", inversedBy="carburation")
     */
    private $periodeCarburation;


    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;


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
     * @return mixed
     */
    public function getPeriodeCarburation()
    {
        return $this->periodeCarburation;
    }

    /**
     * @param mixed $periodeCarburation
     */
    public function setPeriodeCarburation($periodeCarburation)
    {
        $this->periodeCarburation = $periodeCarburation;
    }



    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \Datetime();
    }

    /**
     * @return File
     */
    public function getCarburationFile()
    {
        return $this->carburationFile;
    }

    /**
     * @param File $carburationFile
     */
    public function setCarburationFile($carburationFile)
    {
        $this->carburationFile = $carburationFile;
    }

    /**
     * @return string
     */
    public function getCarburationFileName()
    {
        return $this->carburationFileName;
    }

    /**
     * @param string $carburationFileName
     */
    public function setCarburationFileName($carburationFileName)
    {
        $this->carburationFileName = $carburationFileName;
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
     * Set motif
     *
     * @param string $motif
     *
     * @return Carburation
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
     * @return Carburation
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

