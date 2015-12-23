<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Contrat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\ContratRepository")
 * @Vich\Uploadable
 */
class Contrat
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
     * @ORM\Column(name="dateDebut", type="string", length=255)
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFin", type="string", length=255)
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="duree", type="float")
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="contrat")
     */
    private $employe;


    /**
     * @ORM\ManyToOne(targetEntity="TypeContrat", inversedBy="contrat")
     */
    private $typeContrat;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_contrat", fileNameProperty="contratFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $contratFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $contratFileName;


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
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param float $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }



    /**
     * @return mixed
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * @param mixed $typeContrat
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;
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
    public function getContratFile()
    {
        return $this->contratFile;
    }

    /**
     * @param File $contratFile
     */
    public function setContratFile($contratFile)
    {
        $this->contratFile = $contratFile;
    }

    /**
     * @return string
     */
    public function getContratFileName()
    {
        return $this->contratFileName;
    }

    /**
     * @param string $contratFileName
     */
    public function setContratFileName($contratFileName)
    {
        $this->contratFileName = $contratFileName;
    }



    /**
     * Set dateDebut
     *
     * @param string $dateDebut
     *
     * @return Contrat
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
     * @return Contrat
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
}

