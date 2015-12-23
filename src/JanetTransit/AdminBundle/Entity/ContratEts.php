<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ContratEts
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\ContratEtsRepository")
 * @Vich\Uploadable
 */
class ContratEts
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="representant", type="string", length=255, nullable=true)
     */
    private $representant;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     * @var String
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     *
     * @Vich\UploadableField(mapping="contrat_logo", fileNameProperty="logoFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"image/jpeg", "image/png"},
     * mimeTypesMessage = "Uploader une image au format jpg ou png"
     * )
     *
     * @var File
     */
    private $logoFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $logoFileName;

    /**
     *
     * @Vich\UploadableField(mapping="contrat_file", fileNameProperty="contratFileName")
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
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="TypeContratEts")
     */
    private $typeContratEts;


    public function __toString(){
        return $this->nom;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return ContratEts
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getRepresentant()
    {
        return $this->representant;
    }

    /**
     * @param string $representant
     */
    public function setRepresentant($representant)
    {
        $this->representant = $representant;
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
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    /**
     * @return mixed
     */
    public function getTypeContratEts()
    {
        return $this->typeContratEts;
    }

    /**
     * @param mixed $typeContratEts
     */
    public function setTypeContratEts($typeContratEts)
    {
        $this->typeContratEts = $typeContratEts;
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
     * @return File
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * @param File $logoFile
     */
    public function setLogoFile($logoFile)
    {
        $this->logoFile = $logoFile;
    }

    /**
     * @return string
     */
    public function getLogoFileName()
    {
        return $this->logoFileName;
    }

    /**
     * @param string $logoFileName
     */
    public function setLogoFileName($logoFileName)
    {
        $this->logoFileName = $logoFileName;
    }


    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return ContratEts
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return ContratEts
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }
}

