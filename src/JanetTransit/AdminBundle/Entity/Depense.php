<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Depense
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\DepenseRepository")
 * @Vich\Uploadable
 */
class Depense
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
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;


    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private $employe;


    /**
     * @ORM\ManyToOne(targetEntity="PeriodeDepense", inversedBy="depense", )
     */
    private $periodeDepense;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;


    /**
     * @ORM\ManyToOne(targetEntity="Voiture")
     */
    private $voiture;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;


    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     *
     * @Vich\UploadableField(mapping="depense_file", fileNameProperty="depenseFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $depenseFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $depenseFileName;


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
     * Set materiel
     *
     * @param string $materiel
     *
     * @return Depense
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
     * @return mixed
     */
    public function getVoiture()
    {
        return $this->voiture;
    }

    /**
     * @param mixed $voiture
     */
    public function setVoiture($voiture)
    {
        $this->voiture = $voiture;
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
     * @return mixed
     */
    public function getPeriodeDepense()
    {
        return $this->periodeDepense;
    }

    /**
     * @param mixed $periodeDepense
     */
    public function setPeriodeDepense($periodeDepense)
    {
        $this->periodeDepense = $periodeDepense;
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
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * @param string $motif
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;
    }

    /**
     * @return File
     */
    public function getDepenseFile()
    {
        return $this->depenseFile;
    }

    /**
     * @param File $depenseFile
     */
    public function setDepenseFile($depenseFile)
    {
        $this->depenseFile = $depenseFile;
    }

    /**
     * @return string
     */
    public function getDepenseFileName()
    {
        return $this->depenseFileName;
    }

    /**
     * @param string $depenseFileName
     */
    public function setDepenseFileName($depenseFileName)
    {
        $this->depenseFileName = $depenseFileName;
    }




    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Depense
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

