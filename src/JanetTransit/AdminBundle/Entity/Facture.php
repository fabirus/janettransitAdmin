<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\FactureRepository")
 * @Vich\Uploadable
 */
class Facture
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
     * @ORM\Column(name="heure", type="string", length=255)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroContainer", type="string", length=255)
     */
    private $numeroContainer;


    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255)
     */
    private $depart;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;


    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=255, nullable=true)
     */
    private $client;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Voiture")
     */
    private $voiture;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     *
     * @ORM\Column(name="stationnement", type="float")
     */
    private $stationnement = 0;


    /**
     * @var \boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid = 1;


    /**
     *
     * @Vich\UploadableField(mapping="facture_file", fileNameProperty="factureFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $factureFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $factureFileName;


    /**
     *
     * @Vich\UploadableField(mapping="procces_file", fileNameProperty="proccesFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $proccesFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $proccesFileName;

    /**
     * @var float
     *
     * @ORM\Column(name="percu", type="float")
     */
    private $percu;

    /**
     * @var float
     *
     * @ORM\Column(name="carburation", type="float")
     */
    private $carburation;

    /**
     * @var float
     *
     * @ORM\Column(name="fraisRoute", type="float")
     */
    private $fraisRoute;


    /**
     * @ORM\ManyToOne(targetEntity="PeriodeFacture", inversedBy="facture", )
     */
    private $periodeFacture;


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
    public function getStationnement()
    {
        return $this->stationnement;
    }

    /**
     * @param mixed $stationnement
     */
    public function setStationnement($stationnement)
    {
        $this->stationnement = $stationnement;
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
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param string $depart
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
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
    public function getFactureFile()
    {
        return $this->factureFile;
    }

    /**
     * @param File $factureFile
     */
    public function setFactureFile($factureFile)
    {
        $this->factureFile = $factureFile;
    }

    /**
     * @return string
     */
    public function getFactureFileName()
    {
        return $this->factureFileName;
    }

    /**
     * @param string $factureFileName
     */
    public function setFactureFileName($factureFileName)
    {
        $this->factureFileName = $factureFileName;
    }

    /**
     * @return File
     */
    public function getProccesFile()
    {
        return $this->proccesFile;
    }

    /**
     * @param File $proccesFile
     */
    public function setProccesFile($proccesFile)
    {
        $this->proccesFile = $proccesFile;
    }

    /**
     * @return string
     */
    public function getProccesFileName()
    {
        return $this->proccesFileName;
    }

    /**
     * @param string $proccesFileName
     */
    public function setProccesFileName($proccesFileName)
    {
        $this->proccesFileName = $proccesFileName;
    }

    /**
     * @return mixed
     */
    public function getPeriodeFacture()
    {
        return $this->periodeFacture;
    }

    /**
     * @param mixed $periodeFacture
     */
    public function setPeriodeFacture($periodeFacture)
    {
        $this->periodeFacture = $periodeFacture;
    }



    /**
     * Set heure
     *
     * @param string $heure
     *
     * @return Facture
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return string
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set numeroContainer
     *
     * @param string $numeroContainer
     *
     * @return Facture
     */
    public function setNumeroContainer($numeroContainer)
    {
        $this->numeroContainer = $numeroContainer;

        return $this;
    }

    /**
     * Get numeroContainer
     *
     * @return string
     */
    public function getNumeroContainer()
    {
        return $this->numeroContainer;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Facture
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set percu
     *
     * @param string $percu
     *
     * @return Facture
     */
    public function setPercu($percu)
    {
        $this->percu = $percu;

        return $this;
    }

    /**
     * Get percu
     *
     * @return string
     */
    public function getPercu()
    {
        return $this->percu;
    }

    /**
     * Set carburation
     *
     * @param float $carburation
     *
     * @return Facture
     */
    public function setCarburation($carburation)
    {
        $this->carburation = $carburation;

        return $this;
    }

    /**
     * Get carburation
     *
     * @return float
     */
    public function getCarburation()
    {
        return $this->carburation;
    }

    /**
     * Set fraisRoute
     *
     * @param float $fraisRoute
     *
     * @return Facture
     */
    public function setFraisRoute($fraisRoute)
    {
        $this->fraisRoute = $fraisRoute;

        return $this;
    }

    /**
     * Get fraisRoute
     *
     * @return float
     */
    public function getFraisRoute()
    {
        return $this->fraisRoute;
    }
}

