<?php

namespace VienasVienas\Bundle\BaseBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FOSUBUserProvider extends FOSUBUserProvider for automatic registration with OAuth token.
 */
class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        // On connect - get the access token and the user ID.
        $service = $response->getResourceOwner()->getName();

        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        if (null !== $previousUser = $this->userManager->findUserByUsernameOrEmail(
                array(
                    $property => $username
                )
            )
        ) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // We connect current user.
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $email = $response->getEmail();
        $user = $this->userManager->findUserByEmail($email);

        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        // When the user is registrating.
        if (null === $user) {
            // Create new user here.
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            $user->setEmail($email);
            $user->setPassword($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        // If user exists - go with the HWIOAuth way.


        $user = $this->userManager->findUserByEmail($email);
        if (null === $user || null === $email) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
        }


        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // Update access token.
        $user->$setter($response->getAccessToken());

        return $user;
    }
}
