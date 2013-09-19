<?php

namespace BRS\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="brs_users")
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
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=TRUE)
     */
    protected $facebookId;
	
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
	 * 
	 */
	public function __construct() {
		
		parent::__construct();
		
		$this->properties = new ArrayCollection();
		
	}
	
	/**
	 * 
	 */
    public function serialize() {
    	
        return serialize(array(
        	$this->facebookId,
        	$this->first_name,
        	$this->last_name,
        	$this->date_added,
        	$this->date_updated,
        	$this->security_question,
        	$this->security_answer,
        	parent::serialize(),
		));
		
    }
	
	/**
	 * 
	 */
    public function unserialize($data) {
    	
        list(
        	$this->facebookId,
        	$this->first_name,
        	$this->last_name,
        	$this->date_added,
        	$this->date_updated,
        	$this->security_question,
        	$this->security_answer,
        	$parentData
		) = unserialize($data);
		
        parent::unserialize($parentData);
		
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

}
