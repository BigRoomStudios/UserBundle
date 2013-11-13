<?php

namespace BRS\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="brs_users")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, nullable=true)),
 *      @ORM\AttributeOverride(name="username", column=@ORM\Column(type="string", name="username", length=255, nullable=true, unique=true)),
 *      @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(type="string", name="username_canonical", length=255, nullable=true, unique=true)),
 *      @ORM\AttributeOverride(name="password", column=@ORM\Column(type="string", name="password", length=255, nullable=true))
 * })
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
     * @var integer
     * 
     * @ORM\Column(name="business_id", type="integer", nullable=TRUE)
     */
    private $business_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\QuestionnaireBundle\Entity\Business")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="id")
	 */
	private $business;
	
	/**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=TRUE)
     */
    protected $facebookId;
	
	/**
     * @var string
     *
     * @ORM\Column(name="foursquareId", type="string", length=255, nullable=TRUE)
     */
    protected $foursquareId;
	
    /**
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=TRUE)
	 * @Assert\NotBlank(groups={"BRS_Registration"})
     */
    public $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=TRUE)
     */
    public $last_name;
	
    /**
     * @var date $date_added
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=TRUE)
     */
    public $date_added;

    /**
     * @var date $date_updated
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=TRUE)
     */
    public $date_updated;
	
	/**
     * @var text $security_question
     *
     * @ORM\Column(name="security_question", type="text", nullable=TRUE)
     */
    public $security_question;
	
	/**
     * @var text $security_answer
     *
     * @ORM\Column(name="security_answer", type="text", nullable=TRUE)
     */
    public $security_answer;
	
	/**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=TRUE)
     */
    public $address;
	
	/**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=TRUE)
     */
    public $city;
	
	/**
     * @var string $state
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=TRUE)
     */
    public $state;
    
    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=TRUE)
     */
    public $phone;
	
	/**
     * @ORM\OneToMany(targetEntity="App\QuestionnaireBundle\Entity\Questionnaire", mappedBy="user")	 
     */
    public $questionnaires;
	
	/**
	 * 
	 */
	public function __construct() {
		
		parent::__construct();
		
		$this->questionnaires = new ArrayCollection();
		
	}
	
	/**
	 * 
	 */
    public function serialize() {
    	
        return serialize(array(
        	$this->facebookId,
        	$this->business_id,
        	$this->first_name,
        	$this->last_name,
        	$this->date_added,
        	$this->date_updated,
        	$this->security_question,
        	$this->security_answer,
        	/*$this->foursquareId,
        	$this->address,
        	$this->city,
        	$this->state,
        	$this->phone,*/
        	parent::serialize(),
		));
		
    }
	
	/**
	 * 
	 */
    public function unserialize($data) {
    	
        list(
        	$this->facebookId,
        	$this->business_id,
        	$this->first_name,
        	$this->last_name,
        	$this->date_added,
        	$this->date_updated,
        	$this->security_question,
        	$this->security_answer,
        	/*$this->foursquareId,
        	$this->address,
        	$this->city,
        	$this->state,
        	$this->phone,*/
        	$parentData
		) = unserialize($data);
		
        parent::unserialize($parentData);
		
    }
	
	/**
     * Set the business
     *
     * @param \App\QuestionnaireBundle\Entity\Business business - business the questionnaire is being conducted on
     */
    public function setBusiness(\App\QuestionnaireBundle\Entity\Business $business) {
    	
		//set the business id
        $this->business_id = $business->getId();
		
		//set the business
        $this->business = $business;
    	
    	return $this;
		
    }
	
	/**
     * Get the business
     *
     * @return \App\QuestionnaireBundle\Entity\Business
     */
    public function getBusiness() {
        return $this->business;
    }
	
	/**
     * Get the business id
     *
     * @return business_id
     */
    public function getBusinessId() {
        return $this->business_id;
    }
	
	/**
	 * 
	 */
	public function setEmail($email) {
		
		$this->email = $email;
		$this->username = $email;
		
	}
	
	/**
	 * 
	 */
	public function setEmailCanonical($emailCanonical) {
		
		$this->emailCanonical = $emailCanonical;
		$this->usernameCanonical = $emailCanonical;
		
	}
	
	/**
	 * Set first_name
	 *
	 * @param string $firstName
	 */
	public function setFirstName($firstName)
	{
		$this->first_name = $firstName;
	}
	
	/**
	 * Get first_name
	 *
	 * @return string 
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}
	
	/**
	 * Set last_name
	 *
	 * @param string $lastName
	 */
	public function setLastName($lastName)
	{
		$this->last_name = $lastName;
	}
	
	/**
	 * Get last_name
	 *
	 * @return string 
	 */
	public function getLastName()
	{
		return $this->last_name;
	}
	
	/**
	 * Get the full name of the user (first + last name)
	 * @return string
	 */
	public function getFullName() {
		return $this->getFirstname() . ' ' . $this->getLastname();
	}
	
	/**
	 * @param string $facebookId
	 * @return void
	 */
	public function setFacebookId($facebookId) {
		$this->facebookId = $facebookId;
	}
	
	/**
	 * @return string
	 */
	public function getFacebookId() {
		return $this->facebookId;
	}
	
	/**
	 * @param Array
	 */
	public function setFBData($fbdata)
	{
		if (isset($fbdata['id'])) {
			$this->setFacebookId($fbdata['id']);
			$this->addRole('ROLE_FACEBOOK');
		}
		if (isset($fbdata['first_name'])) {
			$this->setFirstname($fbdata['first_name']);
		}
		if (isset($fbdata['last_name'])) {
			$this->setLastname($fbdata['last_name']);
		}
		if (isset($fbdata['email'])) {
			$this->setEmail($fbdata['email']);
		}
	}
	
	/**
	 * Set date_added
	 *
	 * @param date $dateAdded
	 */
	public function setDateAdded($dateAdded)
	{
		$this->date_added = $dateAdded;
	}
	
	/**
	 * Get date_added
	 *
	 * @return date 
	 */
	public function getDateAdded()
	{
		return $this->date_added;
	}
	
	/**
	 * Set date_updated
	 *
	 * @param date $dateUpdated
	 */
	public function setDateUpdated($dateUpdated)
	{
		$this->date_updated = $dateUpdated;
	}
	
	/**
	 * Get date_updated
	 *
	 * @return date 
	 */
	public function getDateUpdated()
	{
		return $this->date_updated;
	}
	
	/**
	 * Set sequrity_question
	 *
	 * @param string $securityQuestion
	 */
	public function setSecurityQuestion($securityQuestion)
	{
		$this->security_question = $securityQuestion;
	}
	
	/**
	 * Get sequrity_question
	 *
	 * @return string 
	 */
	public function getSecurityQuestion()
	{
		return $this->security_question;
	}
	
	/**
	 * Set sequrity_answer
	 *
	 * @param string $securityAnswer
	 */
	public function setSecurityAnswer($securityAnswer)
	{
		$this->security_answer = $securityAnswer;
	}
	
	/**
	 * Get sequrity_answer
	 *
	 * @return string 
	 */
	public function getSecurityAnswer()
	{
		return $this->security_answer;
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
	 * @param string $foursquareId
	 * @return void
	 */
	public function setFoursquareId($foursquareId) {
		$this->foursquareId = $foursquareId;
	}
	
	/**
	 * @return string
	 */
	public function getFoursquareId() {
		return $this->foursquareId;
	}
	
	/**
	 * Get address
	 *
	 * @return string 
	 */
	public function getAddress()
	{
		return $this->address;
	}
	
	/**
	 * Set last_name
	 *
	 * @param string $address
	 */
	public function setAddress($address)
	{
		$this->address = $address;
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
	 * Set city
	 *
	 * @param string $city
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}
	
	/**
	 * Get state
	 *
	 * @return string 
	 */
	public function getState()
	{
		return $this->state;
	}
	
	/**
	 * Set state
	 *
	 * @param string $state
	 */
	public function setState($state)
	{
		$this->state = $state;
	}
	
	/**
	 * Get phone
	 *
	 * @return string 
	 */
	public function getPhone()
	{
		return $this->phone;
	}
	
	/**
	 * Set phone
	 *
	 * @param string $phone
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	}
	
    /**
     * Add questionnaire
     *
     * @param \App\QuestionnaireBundle\Entity\Questionnaire $questionnaires
     * @return User
     */
    public function addQuestionnaire(\App\QuestionnaireBundle\Entity\Questionnaire $questionnaire) {
    	
	    $this->questionnaires[] = $questionnaire;
    
        return $this;
    }

    /**
     * Remove questionnaire
     *
     * @param \App\QuestionnaireBundle\Entity\Questionnaire $questionnaire
     */
    public function removeQuestionnaire(\App\QuestionnaireBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaires->removeElement($questionnaire);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }
	
}
