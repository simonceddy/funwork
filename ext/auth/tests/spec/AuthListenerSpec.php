<?php

namespace spec\Eddy\Framework\Auth;

use Eddy\Framework\Auth\AuthListener;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthListenerSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authManager
    ) {
        $this->beConstructedWith($tokenStorage, $authManager, 'secretKey');
    }
    

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthListener::class);
    }
    
    function it_has_token_storage()
    {
        $this->getTokenStorage()->shouldBeAnInstanceOf(TokenStorageInterface::class);
    }

    function it_has_an_auth_manager()
    {
        $this->getAuthManager()->shouldBeAnInstanceOf(AuthenticationManagerInterface::class);
    }

    function it_is_an_invokable_listener()
    {
        $this->__invoke();
    }
}
