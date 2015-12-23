<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * DemandePermission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\DemandePermissionRepository")
 * @Vich\Uploadable
 */
class DemandePermission
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
     * @ORM\Column(name="dateDemande", type="string", length=255)
     */
    private $dateDemande;

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
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="demandePermission")
     */
    private $employe;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_permission", fileNameProperty="permissionFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $permissionFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $permissionFileName;


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
    public function getPermissionFile()
    {
        return $this->permissionFile;
    }

    /**
     * @param File $permissionFile
     */
    public function setPermissionFile($permissionFile)
    {
        $this->permissionFile = $permissionFile;
    }

    /**
     * @return string
     */
    public function getPermissionFileName()
    {
        return $this->permissionFileName;
    }

    /**
     * @param string $permissionFileName
     */
    public function setPermissionFileName($permissionFileName)
    {
        $this->permissionFileName = $permissionFileName;
    }



    /**
     * Set dateDemande
     *
     * @param string $dateDemande
     *
     * @return DemandePermission
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return string
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
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
     * Set dateDebut
     *
     * @param string $dateDebut
     *
     * @return DemandePermission
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
     * @return DemandePermission
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
     * @return DemandePermission
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
     * Set valid
     *
     * @param boolean $valid
     *
     * @return DemandePermission
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }
}

