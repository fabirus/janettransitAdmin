<?php

namespace JanetTransit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Employe
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity(repositoryClass="JanetTransit\AdminBundle\Entity\Repository\EmployeRepository")
 * @Vich\Uploadable
 */
class Employe
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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\ManyToOne(targetEntity="Poste", inversedBy="employes")
     */
    private $poste;


    /**
     * @ORM\OneToMany(targetEntity="AvanceSalaire", mappedBy="employe", cascade={"persist"})
     */
    private $avanceSalaire;


    /**
     * @ORM\OneToMany(targetEntity="Reunion", mappedBy="employePresident", cascade={"persist"})
     */
    private $president;


    /**
     * @ORM\OneToMany(targetEntity="Reunion", mappedBy="employeAssistant", cascade={"persist"})
     */
    private $assistant;


    /**
     * @ORM\ManyToMany(targetEntity="Reunion", mappedBy="employeIntervenants", cascade={"persist"})
     */
    private $intervenants;


    /**
     * @ORM\OneToMany(targetEntity="FicheDePaie", mappedBy="employe", cascade={"persist"})
     */
    private $fichedepaie;

    /**
     * @ORM\OneToMany(targetEntity="Carburation", mappedBy="employe", cascade={"persist"})
     */
    private $carburation;

    /**
     * @ORM\OneToMany(targetEntity="Contrat", mappedBy="employe", cascade={"persist"})
     */
    private $contrat;

    /**
     * @ORM\ManyToMany(targetEntity="Tache", mappedBy="employe", cascade={"persist"})
     */
    private $tache;


    /**
     * @ORM\OneToMany(targetEntity="Presence", mappedBy="employe", cascade={"persist"})
     */
    private $presence;

    /**
     * @ORM\OneToMany(targetEntity="Prime", mappedBy="employe", cascade={"persist"})
     */
    private $prime;


    /**
     * @ORM\OneToMany(targetEntity="Sanction", mappedBy="employe", cascade={"persist"})
     */
    private $sanction;


    /**
     * @ORM\OneToMany(targetEntity="DemandePermission", mappedBy="employe", cascade={"persist"})
     */
    private $demandePermission;


    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="employes")
     */
    private $services;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="date_embauche", type="string", length=255)
     */
    private $dateEmbauche;

    /**
     * @var String
     *
     * @ORM\Column(name="date_naissance", type="string", length=255)
     */
    private $dateNaissance;

    /**
     * @var String
     *
     * @ORM\Column(name="ville_naissance", type="string", length=255)
     */
    private $villeNaissance;

    /**
     * @var String
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var String
     *
     * @ORM\Column(name="matricule", type="string", length=255)
     */
    private $matricule;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="del", type="boolean", length=255, options={"default" = 0})
     */
    private $del = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float")
     */
    private $salaire;


    /**
     *
     * @Vich\UploadableField(mapping="employe_image", fileNameProperty="imageName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"image/jpeg", "image/png"},
     * mimeTypesMessage = "Uploader une image au format jpg ou png"
     * )
     *
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;


    /**
     *
     * @Vich\UploadableField(mapping="employe_file_identite", fileNameProperty="identiteFileName")
     * @Assert\File(
     * maxSize="2M",
     * maxSizeMessage = "Taille max 2Mo",
     * mimeTypes = {"application/pdf"},
     * mimeTypesMessage = "Uploader une fichier au format pdf"
     * )
     *
     * @var File
     */
    private $identiteFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $identiteFileName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __toString(){
        return $this->nom. ' '. $this->prenom;

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
    public function getPresident()
    {
        return $this->president;
    }

    /**
     * @param mixed $president
     */
    public function setPresident($president)
    {
        $this->president = $president;
    }

    /**
     * @return mixed
     */
    public function getIntervenants()
    {
        return $this->intervenants;
    }

    /**
     * @param mixed $intervenants
     */
    public function setIntervenants($intervenants)
    {
        $this->intervenants = $intervenants;
    }

    /**
     * @return mixed
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * @param mixed $assistant
     */
    public function setAssistant($assistant)
    {
        $this->assistant = $assistant;
    }



    /**
     * @return mixed
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param mixed $contrat
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
    }

    /**
     * @return mixed
     */
    public function getCarburation()
    {
        return $this->carburation;
    }

    /**
     * @param mixed $carburation
     */
    public function setCarburation($carburation)
    {
        $this->carburation = $carburation;
    }



    /**
     * @return mixed
     */
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * @param mixed $tache
     */
    public function setTache($tache)
    {
        $this->tache = $tache;
    }





    /**
     * @return float
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param float $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }

    /**
     * @return mixed
     */
    public function getFichedepaie()
    {
        return $this->fichedepaie;
    }

    /**
     * @param mixed $fichedepaie
     */
    public function setFichedepaie($fichedepaie)
    {
        $this->fichedepaie = $fichedepaie;
    }



    /**
     * @return String
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param String $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }



    /**
     * @return mixed
     */
    public function getPrime()
    {
        return $this->prime;
    }

    /**
     * @param mixed $prime
     */
    public function setPrime($prime)
    {
        $this->prime = $prime;
    }



    /**
     * @return mixed
     */
    public function getSanction()
    {
        return $this->sanction;
    }

    /**
     * @param mixed $sanction
     */
    public function setSanction($sanction)
    {
        $this->sanction = $sanction;
    }

    /**
     * @return mixed
     */
    public function getDemandePermission()
    {
        return $this->demandePermission;
    }

    /**
     * @param mixed $demandePermission
     */
    public function setDemandePermission($demandePermission)
    {
        $this->demandePermission = $demandePermission;
    }



    /**
     * @return mixed
     */
    public function getPresence()
    {
        return $this->presence;
    }

    /**
     * @param mixed $presence
     */
    public function setPresence($presence)
    {
        $this->presence = $presence;
    }



    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @return mixed
     */
    public function getAvanceSalaire()
    {
        return $this->avanceSalaire;
    }

    /**
     * @param mixed $avanceSalaire
     */
    public function setAvanceSalaire($avanceSalaire)
    {
        $this->avanceSalaire = $avanceSalaire;
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
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * @param mixed $poste
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;
    }




    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return \DateTime
     */
    public function getVilleNaissance()
    {
        return $this->villeNaissance;
    }

    /**
     * @param \DateTime $villeNaissance
     */
    public function setVilleNaissance($villeNaissance)
    {
        $this->villeNaissance = $villeNaissance;
    }



    /**
     * @return File
     */
    public function getIdentiteFile()
    {
        return $this->identiteFile;
    }

    /**
     * @param File $identiteFile
     */
    public function setIdentiteFile($identiteFile)
    {
        $this->identiteFile = $identiteFile;
    }

    /**
     * @return string
     */
    public function getIdentiteFileName()
    {
        return $this->identiteFileName;
    }

    /**
     * @param string $identiteFileName
     */
    public function setIdentiteFileName($identiteFileName)
    {
        $this->identiteFileName = $identiteFileName;
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
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }


    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
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
     * @return Employe
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
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }



    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Employe
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Employe
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

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     *
     * @return Employe
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return \DateTime
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }
}

