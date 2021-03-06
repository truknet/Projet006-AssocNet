<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Associations
 *
 * @ORM\Table(name="associations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AssociationsRepository")
 */
class Associations
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categories", inversedBy="associations")
     * @ORM\JoinColumn(nullable=false, onDelete="RESTRICT")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $approuvedBy;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Showcase", cascade={"persist", "remove"})
     */
    private $showcase;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateRecord = new \DateTime();
    }

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     *
     * @Assert\File(mimeTypes={"image/jpeg", "image/png"})
     */
    private $logo;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRecord", type="datetime")
     */
    private $dateRecord;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="searchaddress", type="string", length=255)
     */
    private $searchaddress;


    /**
     * @var string
     *
     * @ORM\Column(name="numstreet", type="string", length=255, nullable=true)
     */
    private $numstreet;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="postalcode", type="string", length=255)
     *
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=255)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="hits", type="integer", nullable=true)
     */
    private $hits;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateApproval", type="datetime", nullable=true)
     */
    private $dateApproval;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var text
     *
     * @ORM\Column(name="rejectMessage", type="text", nullable=true)
     */
    private $rejectMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="rna", type="string", length=255, nullable=true)
     */
    private $rna;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="text", nullable=true)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="placeId", type="string", length=255, nullable=true)
     */
    private $placeId;




    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Associations
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Associations
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set dateRecord
     *
     * @param \DateTime $dateRecord
     *
     * @return Associations
     */
    public function setDateRecord($dateRecord)
    {
        $this->dateRecord = $dateRecord;

        return $this;
    }

    /**
     * Get dateRecord
     *
     * @return \DateTime
     */
    public function getDateRecord()
    {
        return $this->dateRecord;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Associations
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set searchaddress
     *
     * @param string $searchaddress
     *
     * @return Associations
     */
    public function setSearchaddress($searchaddress)
    {
        $this->searchaddress = $searchaddress;

        return $this;
    }

    /**
     * Get searchaddress
     *
     * @return string
     */
    public function getSearchaddress()
    {
        return $this->searchaddress;
    }

    /**
     * Set numstreet
     *
     * @param string $numstreet
     *
     * @return Associations
     */
    public function setNumstreet($numstreet)
    {
        $this->numstreet = $numstreet;

        return $this;
    }

    /**
     * Get numstreet
     *
     * @return string
     */
    public function getNumstreet()
    {
        return $this->numstreet;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return Associations
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return Associations
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set postalcode
     *
     * @param string $postalcode
     *
     * @return Associations
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    /**
     * Get postalcode
     *
     * @return string
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Associations
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Associations
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return Associations
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Associations
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Associations
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     *
     * @return Associations
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * Get hits
     *
     * @return integer
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Associations
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateApproval
     *
     * @param \DateTime $dateApproval
     *
     * @return Associations
     */
    public function setDateApproval($dateApproval)
    {
        $this->dateApproval = $dateApproval;

        return $this;
    }

    /**
     * Get dateApproval
     *
     * @return \DateTime
     */
    public function getDateApproval()
    {
        return $this->dateApproval;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Associations
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set rejectMessage
     *
     * @param string $rejectMessage
     *
     * @return Associations
     */
    public function setRejectMessage($rejectMessage)
    {
        $this->rejectMessage = $rejectMessage;

        return $this;
    }

    /**
     * Get rejectMessage
     *
     * @return string
     */
    public function getRejectMessage()
    {
        return $this->rejectMessage;
    }

    /**
     * Set rna
     *
     * @param string $rna
     *
     * @return Associations
     */
    public function setRna($rna)
    {
        $this->rna = $rna;

        return $this;
    }

    /**
     * Get rna
     *
     * @return string
     */
    public function getRna()
    {
        return $this->rna;
    }

    /**
     * Set object
     *
     * @param string $object
     *
     * @return Associations
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Associations
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categories $categorie
     *
     * @return Associations
     */
    public function setCategorie(\AppBundle\Entity\Categories $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categories
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Associations
     */
    public function setAuthor(\AppBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set approuvedBy
     *
     * @param \AppBundle\Entity\User $approuvedBy
     *
     * @return Associations
     */
    public function setApprouvedBy(\AppBundle\Entity\User $approuvedBy = null)
    {
        $this->approuvedBy = $approuvedBy;

        return $this;
    }

    /**
     * Get approuvedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getApprouvedBy()
    {
        return $this->approuvedBy;
    }

    /**
     * Set placeId
     *
     * @param string $placeId
     *
     * @return Associations
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;

        return $this;
    }

    /**
     * Get placeId
     *
     * @return string
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * Set showcase
     *
     * @param \AppBundle\Entity\Showcase $showcase
     *
     * @return Associations
     */
    public function setShowcase(\AppBundle\Entity\Showcase $showcase = null)
    {
        $this->showcase = $showcase;

        return $this;
    }

    /**
     * Get showcase
     *
     * @return \AppBundle\Entity\Showcase
     */
    public function getShowcase()
    {
        return $this->showcase;
    }
}
