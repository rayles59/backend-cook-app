<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oauth2Client
 *
 * @ORM\Table(name="oauth2_client")
 * @ORM\Entity
 */
class Oauth2Client
{
    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=32, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="secret", type="string", length=128, nullable=true)
     */
    private $secret;

    /**
     * @var oauth2_redirect_uri|null
     *
     * @ORM\Column(name="redirect_uris", type="oauth2_redirect_uri", nullable=true)
     */
    private $redirectUris;

    /**
     * @var oauth2_grant|null
     *
     * @ORM\Column(name="grants", type="oauth2_grant", nullable=true)
     */
    private $grants;

    /**
     * @var oauth2_scope|null
     *
     * @ORM\Column(name="scopes", type="oauth2_scope", nullable=true)
     */
    private $scopes;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="allow_plain_text_pkce", type="boolean", nullable=false)
     */
    private $allowPlainTextPkce = '0';

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(?string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getRedirectUris()
    {
        return $this->redirectUris;
    }

    public function setRedirectUris($redirectUris): self
    {
        $this->redirectUris = $redirectUris;

        return $this;
    }

    public function getGrants()
    {
        return $this->grants;
    }

    public function setGrants($grants): self
    {
        $this->grants = $grants;

        return $this;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function setScopes($scopes): self
    {
        $this->scopes = $scopes;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isAllowPlainTextPkce(): ?bool
    {
        return $this->allowPlainTextPkce;
    }

    public function setAllowPlainTextPkce(bool $allowPlainTextPkce): self
    {
        $this->allowPlainTextPkce = $allowPlainTextPkce;

        return $this;
    }


}
