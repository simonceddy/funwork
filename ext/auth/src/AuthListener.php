<?php
namespace Eddy\Framework\Auth;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthListener
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private AuthenticationManagerInterface $authManager,
        private string $providerKey
    ) {}

    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    public function getAuthManager()
    {
        return $this->authManager;
    }

    public function __invoke()
    {
        $unauthedToken = new UsernamePasswordToken(
            'simon',
            'password',
            $this->providerKey
        );

        // dd($unauthedToken);
        $authedToken = $this->authManager->authenticate($unauthedToken);

        $this->tokenStorage->setToken($authedToken);

    }
}
