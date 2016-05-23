<?php
namespace Sandstorm\UserManagement\Command;

use Sandstorm\UserManagement\Domain\Repository\UserRepository;
use Sandstorm\UserManagement\Domain\Service\UserManagementService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\AccountFactory;
use TYPO3\Flow\Security\AccountRepository;
use Sandstorm\UserManagement\Domain\Model\User;

/**
 * @Flow\Scope("singleton")
 */
class UserCommandController extends \TYPO3\Flow\Cli\CommandController
{

    /**
     * @Flow\Inject
     * @var AccountFactory
     */
    protected $accountFactory;

    /**
     * @Flow\Inject
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @Flow\Inject
     * @var UserManagementService
     */
    protected $userManagementService;

    /**
     * @Flow\Inject
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create User on the Command Line
     *
     * @param string $email The email address, which also serves as the username.
     * @param string $password This user's password.
     * @param string $firstName
     * @param string $lastName
     * @param string $roles A comma-separated list of roles this user will get.
     */
    public function createCommand($email, $password, $firstName, $lastName, $roles)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $this->userManagementService->createAccount($user, $password, explode(',', $roles));
        $this->userRepository->add($user);
        $this->outputLine('Added the User <b>"%s"</b> with password <b>"%s"</b>.', array($user->getAccountName(), $password));
    }
}