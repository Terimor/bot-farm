<?php

namespace App\Entity;

use App\Repository\VKAccountRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VKAccountRepository::class)]
class VKAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $providerId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $accessToken = null;

    #[ORM\Column(type: 'text')]
    private ?string $messageText;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $lastSuccessfulProceed = null;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProviderId(): int
    {
        return $this->providerId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getMessageText(): ?string
    {
        return $this->messageText;
    }

    public function setMessageText(?string $messageText): void
    {
        $this->messageText = $messageText;
    }

    public function getLastSuccessfulProceed(): ?DateTimeImmutable
    {
        return $this->lastSuccessfulProceed;
    }

    public function setLastSuccessfulProceed(?DateTimeImmutable $lastSuccessfulProceed): void
    {
        $this->lastSuccessfulProceed = $lastSuccessfulProceed;
    }
}
