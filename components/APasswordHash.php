<?php
/**
 * Represents a password hash.
 * <pre>
 * $hash = new APasswordHash($user->password, $user->email);
 * echo $hash;
 * </pre>
 */
class APasswordHash extends CComponent {
	/**
	 * The salt to use when hashing
	 * @var string
	 */
	public $salt;
	/**
	 * The number of hashing iterations to perform
	 * @var integer
	 */
	public $iterations = 100;

	/**
	 * The user's password hash
	 * @var string
	 */
	private $_hash;

	/**
	 * The plain text password
	 * @var string
	 */
	private $_password;

	/**
	 * Constructor.
	 * @param string $password the password to hash
	 * @param string|null $salt the salt to use
	 */
	public function __construct($password,$salt = null) {
		$this->_password = $password;
		if ($salt !== null) {
			$this->salt = $salt;
		}
	}

	/**
	 * Gets the hash of the password
	 * @return string
	 */
	public function getHash()
	{
		if ($this->_hash === null) {
			$this->_hash = $this->computeHash();
		}
		return $this->_hash;
	}
	/**
	 * Computes the salted hash for the password
	 * @return string the salted hash
	 */
	protected function computeHash() {
		$hash = $this->salt."###".$this->_password;
		for($i = 0; $i < $this->iterations; $i++) {
			$hash = sha1($hash);
		}
		return $hash;
	}

	/**
	 * Gets the password hash
	 * @return string the password hash
	 */
	public function __toString() {
		return $this->getHash();
	}
}