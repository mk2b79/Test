<?php

namespace API\Models\Zendesk;

class UserZd
{
    function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?string $timeZone,
        private ?int $companyId
    )
    {}
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getTimeZone(): string { return $this->timeZone; }

    public function getCompanyId(): int{return $this->companyId;}
}