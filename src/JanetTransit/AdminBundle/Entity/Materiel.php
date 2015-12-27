<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Materiel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\MaterielRepository")
 * @Vich\Uploadable
 */
class Materiel
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
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;


    /**
     * @var integer
     *
     * @ORM\Column(name="qteStock", type="integer")
     */
    private $qte;


    /**
     * @ORM\ManyToOne(targetEntity="Stock")
     */
    private $stock;


    /**
     *
     * @Vich\UploadableField(mapping="materiel_file", fileNameProperty="materielFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $materielFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $materielFileName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private $employe;


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
    public function getAt()
    {
        return $this->at;
    }

    /**
     * @param string $at
     */
    public function setAt($at)
    {
        $this->at = $at;
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
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }


    /**
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
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
    public function getMaterielFile()
    {
        return $this->materielFile;
    }

    /**
     * @param File $materielFile
     */
    public function setMaterielFile($materielFile)
    {
        $this->materielFile = $materielFile;
    }

    /**
     * @return string
     */
    public function getMaterielFileName()
    {
        return $this->materielFileName;
    }

    /**
     * @param string $materielFileName
     */
    public function setMaterielFileName($materielFileName)
    {
        $this->materielFileName = $materielFileName;
    }





    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return Materiel
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

