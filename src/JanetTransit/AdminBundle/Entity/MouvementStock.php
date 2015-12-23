<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * MouvementStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\MouvementStockRepository")
 * @Vich\Uploadable
 */
class MouvementStock
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="heureMouvement", type="string", length=255)
     */
    private $heureMouvement;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text")
     */
    private $motif;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private $employe;


    /**
     * @ORM\ManyToOne(targetEntity="PeriodeStock")
     */
    private $periodeStock;

    /**
     *
     * @Vich\UploadableField(mapping="mouvement_stock_file", fileNameProperty="stockFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $stockFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $stockFileName;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean")
     */
    private $del = 0;


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
     * Set type
     *
     * @param string $type
     *
     * @return MouvementStock
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }


    /**
     * @return string
     */
    public function getHeureMouvement()
    {
        return $this->heureMouvement;
    }

    /**
     * @param string $heureMouvement
     */
    public function setHeureMouvement($heureMouvement)
    {
        $this->heureMouvement = $heureMouvement;
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
    public function getPeriodeStock()
    {
        return $this->periodeStock;
    }

    /**
     * @param mixed $periodeStock
     */
    public function setPeriodeStock($periodeStock)
    {
        $this->periodeStock = $periodeStock;
    }



    /**
     * @return File
     */
    public function getStockFile()
    {
        return $this->stockFile;
    }

    /**
     * @param File $stockFile
     */
    public function setStockFile($stockFile)
    {
        $this->stockFile = $stockFile;
    }

    /**
     * @return string
     */
    public function getStockFileName()
    {
        return $this->stockFileName;
    }

    /**
     * @param string $stockFileName
     */
    public function setStockFileName($stockFileName)
    {
        $this->stockFileName = $stockFileName;
    }



    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return MouvementStock
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
     * Set qte
     *
     * @param float $qte
     *
     * @return MouvementStock
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }
}

