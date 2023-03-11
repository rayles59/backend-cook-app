<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oauth2AccessToken
 *
 * @ORM\Table(name="oauth2_access_token", indexes={@ORM\Index(name="IDX_454D9673C7440455", columns={"client"})})
 * @ORM\Entity
 */
class Oauth2AccessToken
{
    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=80, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $identifier;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="expiry", type="datetime_immutable", nullable=false)
     */
    private $expiry;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_identifier", type="string", length=128, nullable=true)
     */
    private $userIdentifier;

    /**
     * @var oauth2_scope|null
     *
     * @ORM\Column(name="scopes", type="oauth2_scope", nullable=true)
     */
    private $scopes;

    /**
     * @var bool
     *
     * @ORM\Column(name="revoked", type="boolean", nullable=false)
     */
    private $revoked;

    /**
     * @var \Oauth2Client
     *
     * @ORM\ManyToOne(targetEntity="Oauth2Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="identifier")
     * })
     */
    private $client;

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function getExpiry(): ?\DateTimeImmutable
    {
        return $this->expiry;
    }

    public function setExpiry(\DateTimeImmutable $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(?string $userIdentifier): self
    {
        $this->userIdentifier = $userIdentifier;

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

    public function isRevoked(): ?bool
    {
        return $this->revoked;
    }

    public function setRevoked(bool $revoked): self
    {
        $this->revoked = $revoked;

        return $this;
    }

    public function getClient(): ?Oauth2Client
    {
        return $this->client;
    }

    public function setClient(?Oauth2Client $client): self
    {
        $this->client = $client;

        return $this;
    }


}
