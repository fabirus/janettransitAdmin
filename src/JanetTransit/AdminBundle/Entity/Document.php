<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\DocumentRepository")
 * @Vich\Uploadable
 */
class Document
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
     * @ORM\Column(name="dateFait", type="string", length=255)
     */
    private $dateFait;

    /**
     * @var string
     *
     * @ORM\Column(name="dateEcheance", type="string", length=255)
     */
    private $dateEcheance;

    /**
     * @ORM\ManyToOne(targetEntity="Voiture")
     */
    private $voiture;


    /**
     * @ORM\ManyToOne(targetEntity="TypeDocument")
     */
    private $typeDocument;


    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     *
     * @Vich\UploadableField(mapping="voiture_document", fileNameProperty="documentFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $documentFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $documentFileName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


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
     * @return string
     */
    public function getDocumentFileName()
    {
        return $this->documentFileName;
    }

    /**
     * @param string $documentFileName
     */
    public function setDocumentFileName($documentFileName)
    {
        $this->documentFileName = $documentFileName;
    }

    /**
     * @return File
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param File $documentFile
     */
    public function setDocumentFile($documentFile)
    {
        $this->documentFile = $documentFile;
    }



    /**
     * @return mixed
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }

    /**
     * @param mixed $typeDocument
     */
    public function setTypeDocument($typeDocument)
    {
        $this->typeDocument = $typeDocument;
    }



    /**
     * Set dateFait
     *
     * @param string $dateFait
     *
     * @return Document
     */
    public function setDateFait($dateFait)
    {
        $this->dateFait = $dateFait;

        return $this;
    }

    /**
     * Get dateFait
     *
     * @return string
     */
    public function getDateFait()
    {
        return $this->dateFait;
    }

    /**
     * Set dateEcheance
     *
     * @param string $dateEcheance
     *
     * @return Document
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    /**
     * Get dateEcheance
     *
     * @return string
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }
}

