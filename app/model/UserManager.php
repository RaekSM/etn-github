<?php

namespace App\Model;

use App\UserEntity;
use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{
	const
		TABLE_NAME = 'user_entity',
		COLUMN_ID = 'id',
		COLUMN_LOGIN = 'login',
		COLUMN_PASSWORD_HASH = 'password';


	/**
	 * @var \Kdyby\Doctrine\EntityManager
	 */
    public $em;

	public function __construct(\Kdyby\Doctrine\EntityManager $entityManager)
	{
		$this->em = $entityManager;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$row = $this->em->getRepository(UserEntity::getClassName())->findOneBy(array('login'=>$username));

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row->password)) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		}

		$arr = array('id' => $row->id, 'role' => '');
		return new Nette\Security\Identity($arr[self::COLUMN_ID], $arr['role'], $arr);
	}

}



class DuplicateNameException extends \Exception
{}
