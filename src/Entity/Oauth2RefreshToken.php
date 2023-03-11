<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oauth2RefreshToken
 *
 * @ORM\Table(name="oauth2_refresh_token", indexes={@ORM\Index(name="IDX_4DD90732B6A2DD68", columns={"access_token"})})
 * @ORM\Entity
 */
class Oauth2RefreshToken
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
     * @var bool
     *
     * @ORM\Column(name="revoked", type="boolean", nullable=false)
     */
    private $revoked;

    /**
     * @var \Oauth2AccessToken
     *
     * @ORM\ManyToOne(targetEntity="Oauth2AccessToken")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_token", referencedColumnName="identifier")
     * })
     */
    private $accessToken;

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

    public function isRevoked(): ?bool
    {
        return $this->revoked;
    }

    public function setRevoked(bool $revoked): self
    {
        $this->revoked = $revoked;

        return $this;
    }

    public function getAccessToken(): ?Oauth2AccessToken
    {
        return $this->accessToken;
    }

    public function setAccessToken(?Oauth2AccessToken $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }


}
