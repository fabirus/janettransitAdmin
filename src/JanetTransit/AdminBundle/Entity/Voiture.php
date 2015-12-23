<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Voiture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\VoitureRepository")
 * @Vich\Uploadable
 */
class Voiture
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
     * @ORM\Column(name="immatricule", type="string", length=255)
     */
    private $immatricule;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=255, nullable=true)
     */
    private $modele;

    /**
     * @ORM\ManyToOne(targetEntity="TypeVoiture", inversedBy="voiture")
     */
    private $typeVoiture;

    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private $chauffeur;

    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private $motoboy;

    /**
     * @ORM\ManyToOne(targetEntity="Marque")
     */
    private $marque;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     *
     * @Vich\UploadableField(mapping="voiture_cartegrise", fileNameProperty="cartegriseFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $cartegriseFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $cartegriseFileName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    public function __toString(){

        return $this->immatricule.'  '.$this->chauffeur;
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
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * @param string $modele
     */
    public function setModele($modele)
    {
        $this->modele = $modele;
    }



    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param mixed $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }



    /**
     * @return File
     */
    public function getCartegriseFile()
    {
        return $this->cartegriseFile;
    }

    /**
     * @param File $cartegriseFile
     */
    public function setCartegriseFile($cartegriseFile)
    {
        $this->cartegriseFile = $cartegriseFile;
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
    public function getCartegriseFileName()
    {
        return $this->cartegriseFileName;
    }

    /**
     * @param string $cartegriseFileName
     */
    public function setCartegriseFileName($cartegriseFileName)
    {
        $this->cartegriseFileName = $cartegriseFileName;
    }



    /**
     * @return mixed
     */
    public function getTypeVoiture()
    {
        return $this->typeVoiture;
    }

    /**
     * @param mixed $typeVoiture
     */
    public function setTypeVoiture($typeVoiture)
    {
        $this->typeVoiture = $typeVoiture;
    }

    /**
     * @return mixed
     */
    public function getChauffeur()
    {
        return $this->chauffeur;
    }

    /**
     * @param mixed $chauffeur
     */
    public function setChauffeur($chauffeur)
    {
        $this->chauffeur = $chauffeur;
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
    public function getMotoboy()
    {
        return $this->motoboy;
    }

    /**
     * @param mixed $motoboy
     */
    public function setMotoboy($motoboy)
    {
        $this->motoboy = $motoboy;
    }



    /**
     * Set immatricule
     *
     * @param string $immatricule
     *
     * @return Voiture
     */
    public function setImmatricule($immatricule)
    {
        $this->immatricule = $immatricule;

        return $this;
    }

    /**
     * Get immatricule
     *
     * @return string
     */
    public function getImmatricule()
    {
        return $this->immatricule;
    }
}

