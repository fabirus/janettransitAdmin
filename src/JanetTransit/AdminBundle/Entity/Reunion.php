<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Reunion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\ReunionRepository")
 * @Vich\Uploadable
 */
class Reunion
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
     * @ORM\Column(name="dateReunion", type="string", length=255)
     */
    private $dateReunion;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="compteRendu", type="text", nullable=true)
     */
    private $compteRendu;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="president")
     */
    private $employePresident;


    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="assistant")
     */
    private $employeAssistant;

    /**
     * @ORM\ManyToMany(targetEntity="Employe", inversedBy="intervenants")
     */
    private $employeIntervenants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $reunionFileName;

    /**
     *
     * @Vich\UploadableField(mapping="file_reunion", fileNameProperty="reunionFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $reunionFile;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;


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
     * @return string
     */
    public function getReunionFileName()
    {
        return $this->reunionFileName;
    }

    /**
     * @param string $reunionFileName
     */
    public function setReunionFileName($reunionFileName)
    {
        $this->reunionFileName = $reunionFileName;
    }

    /**
     * @return File
     */
    public function getReunionFile()
    {
        return $this->reunionFile;
    }

    /**
     * @param File $reunionFile
     */
    public function setReunionFile($reunionFile)
    {
        $this->reunionFile = $reunionFile;
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
    public function getEmployeIntervenants()
    {
        return $this->employeIntervenants;
    }

    /**
     * @param mixed $employeIntervenants
     */
    public function setEmployeIntervenants($employeIntervenants)
    {
        $this->employeIntervenants = $employeIntervenants;
    }

    /**
     * @return mixed
     */
    public function getEmployeAssistant()
    {
        return $this->employeAssistant;
    }

    /**
     * @param mixed $employeAssistant
     */
    public function setEmployeAssistant($employeAssistant)
    {
        $this->employeAssistant = $employeAssistant;
    }

    /**
     * @return mixed
     */
    public function getEmployePresident()
    {
        return $this->employePresident;
    }

    /**
     * @param mixed $employePresident
     */
    public function setEmployePresident($employePresident)
    {
        $this->employePresident = $employePresident;
    }


    /**
     * Set dateReunion
     *
     * @param string $dateReunion
     *
     * @return Reunion
     */
    public function setDateReunion($dateReunion)
    {
        $this->dateReunion = $dateReunion;

        return $this;
    }

    /**
     * Get dateReunion
     *
     * @return string
     */
    public function getDateReunion()
    {
        return $this->dateReunion;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Reunion
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set compteRendu
     *
     * @param string $compteRendu
     *
     * @return Reunion
     */
    public function setCompteRendu($compteRendu)
    {
        $this->compteRendu = $compteRendu;

        return $this;
    }

    /**
     * Get compteRendu
     *
     * @return string
     */
    public function getCompteRendu()
    {
        return $this->compteRendu;
    }
}

