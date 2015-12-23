<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Presence
 *
 * @ORM\Table(name="presence")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\PresenceRepository")
 * @Vich\Uploadable
 */
class Presence
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
     * @ORM\Column(name="at", type="string", length=255)
     */
    private $at;

    /**
     * @var string
     *
     * @ORM\Column(name="heureArrivee", type="string", length=255)
     */
    private $heureArrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="heureDepart", type="string", length=255)
     */
    private $heureDepart;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="presence")
     */
    private $employe;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_absence", fileNameProperty="absenceFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $absenceFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $absenceFileName;


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
    public function getAbsenceFile()
    {
        return $this->absenceFile;
    }

    /**
     * @param File $absenceFile
     */
    public function setAbsenceFile($absenceFile)
    {
        $this->absenceFile = $absenceFile;
    }

    /**
     * @return string
     */
    public function getAbsenceFileName()
    {
        return $this->absenceFileName;
    }

    /**
     * @param string $absenceFileName
     */
    public function setAbsenceFileName($absenceFileName)
    {
        $this->absenceFileName = $absenceFileName;
    }





    /**
     * Set at
     *
     * @param string $at
     *
     * @return Presence
     */
    public function setAt($at)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at
     *
     * @return string
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Set heureArrivee
     *
     * @param string $heureArrivee
     *
     * @return Presence
     */
    public function setHeureArrivee($heureArrivee)
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get heureArrivee
     *
     * @return string
     */
    public function getHeureArrivee()
    {
        return $this->heureArrivee;
    }

    /**
     * Set heureDepart
     *
     * @param string $heureDepart
     *
     * @return Presence
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get heureDepart
     *
     * @return string
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return Presence
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set infos
     *
     * @param string $infos
     *
     * @return Presence
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string
     */
    public function getInfos()
    {
        return $this->infos;
    }
}

