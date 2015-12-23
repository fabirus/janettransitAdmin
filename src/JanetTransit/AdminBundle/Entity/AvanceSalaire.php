<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * AvanceSalaire
 *
 * @ORM\Table(name="avancesalaire")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\AvanceSalaireRepository")
 * @Vich\Uploadable
 */
class AvanceSalaire
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
     * @ORM\Column(name="At", type="string")
     */
    private $at;

    /**
     * @var string
     *
     * @ORM\Column(name="periode", type="string")
     */
    private $periode;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

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
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_avance", fileNameProperty="avanceFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $avanceFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $avanceFileName;


    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="avanceSalaire")
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
     * @return string
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * @param string $periode
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }



    /**
     * @return File
     */
    public function getAvanceFile()
    {
        return $this->avanceFile;
    }

    /**
     * @param File $avanceFile
     */
    public function setAvanceFile($avanceFile)
    {
        $this->avanceFile = $avanceFile;
    }

    /**
     * @return string
     */
    public function getAvanceFileName()
    {
        return $this->avanceFileName;
    }

    /**
     * @param string $avanceFileName
     */
    public function setAvanceFileName($avanceFileName)
    {
        $this->avanceFileName = $avanceFileName;
    }



    /**
     * Set at
     *
     * @param \DateTime $at
     *
     * @return AvanceSalaire
     */
    public function setAt($at)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at
     *
     * @return \DateTime
     */
    public function getAt()
    {
        return $this->at;
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
     * Set montant
     *
     * @param float $montant
     *
     * @return AvanceSalaire
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

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return AvanceSalaire
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

