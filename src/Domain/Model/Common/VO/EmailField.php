<?php

declare(strict_types=1);

namespace Domain\Model\Common\VO;

use Domain\Model\Common\InvalidEmail;

final class EmailField
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail();
        }
        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
