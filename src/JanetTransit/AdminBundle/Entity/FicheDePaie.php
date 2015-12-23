<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * FicheDePaie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\FicheDePaieRepository")
 * @Vich\Uploadable
 */
class FicheDePaie
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
     * @ORM\Column(name="periode", type="string", length=255)
     */
    private $periode;

    /**
     *
     * @ORM\Column(name="observation", type="text")
     */
    private $observation;

    /**
     *
     * @ORM\Column(name="recommandation", type="text")
     */
    private $recommandation;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     *
     * @Vich\UploadableField(mapping="employe_file_fichedepaie", fileNameProperty="fichedepaieFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $fichedepaieFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $fichedepaieFileName;

    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="fichedepaie")
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
     * @return mixed
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    }

    /**
     * @return mixed
     */
    public function getRecommandation()
    {
        return $this->recommandation;
    }

    /**
     * @param mixed $recommandation
     */
    public function setRecommandation($recommandation)
    {
        $this->recommandation = $recommandation;
    }



    /**
     * Set periode
     *
     * @param string $periode
     *
     * @return FicheDePaie
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * Get periode
     *
     * @return string
     */
    public function getPeriode()
    {
        return $this->periode;
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
    public function getFichedepaieFile()
    {
        return $this->fichedepaieFile;
    }

    /**
     * @param File $fichedepaieFile
     */
    public function setFichedepaieFile($fichedepaieFile)
    {
        $this->fichedepaieFile = $fichedepaieFile;
    }

    /**
     * @return string
     */
    public function getFichedepaieFileName()
    {
        return $this->fichedepaieFileName;
    }

    /**
     * @param string $fichedepaieFileName
     */
    public function setFichedepaieFileName($fichedepaieFileName)
    {
        $this->fichedepaieFileName = $fichedepaieFileName;
    }


}

