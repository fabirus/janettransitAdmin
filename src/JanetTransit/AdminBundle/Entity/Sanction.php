<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Sanction
 *
 * @ORM\Table(name="sanction")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\SanctionRepository")
 * @Vich\Uploadable
 */
class Sanction
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
     * @ORM\Column(name="dateSanction", type="string", length=255)
     */
    private $dateSanction;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="dateDebut", type="string", length=255)
     */
    private $dateDebut;

    /**
     * @var float
     *
     * @ORM\Column(name="retenuSalaire", type="float")
     */
    private $retenuSalaire = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFin", type="string", length=255)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="sanction")
     */
    private $employe;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_sanction", fileNameProperty="sanctionFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $sanctionFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $sanctionFileName;



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
     * @return float
     */
    public function getRetenuSalaire()
    {
        return $this->retenuSalaire;
    }

    /**
     * @param float $retenuSalaire
     */
    public function setRetenuSalaire($retenuSalaire)
    {
        $this->retenuSalaire = $retenuSalaire;
    }



    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \Datetime();
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
     * @return File
     */
    public function getSanctionFile()
    {
        return $this->sanctionFile;
    }

    /**
     * @param File $sanctionFile
     */
    public function setSanctionFile($sanctionFile)
    {
        $this->sanctionFile = $sanctionFile;
    }

    /**
     * @return string
     */
    public function getSanctionFileName()
    {
        return $this->sanctionFileName;
    }

    /**
     * @param string $sanctionFileName
     */
    public function setSanctionFileName($sanctionFileName)
    {
        $this->sanctionFileName = $sanctionFileName;
    }



    /**
     * Set dateSanction
     *
     * @param string $dateSanction
     *
     * @return Sanction
     */
    public function setDateSanction($dateSanction)
    {
        $this->dateSanction = $dateSanction;

        return $this;
    }

    /**
     * Get dateSanction
     *
     * @return string
     */
    public function getDateSanction()
    {
        return $this->dateSanction;
    }

    /**
     * Set dateDebut
     *
     * @param string $dateDebut
     *
     * @return Sanction
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return string
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin
     *
     * @return Sanction
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return Sanction
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
}

