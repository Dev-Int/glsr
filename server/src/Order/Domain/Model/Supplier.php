<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Order\Domain\Model;

final class Supplier
{
    private string $name;
    private string $address;
    private string $email;
    private Articles $articles;
    private array $orderDays;

    public function __construct(
        string $name,
        string $address,
        string $email,
        array $orderDays
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->orderDays = $orderDays;
        $this->articles = new Articles();
    }

    public static function create(
        string $name,
        string $address,
        string $email,
        array $orderDays
    ): self {
        return new self($name, $address, $email, $orderDays);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function articles(): Articles
    {
        return $this->articles;
    }

    public function assignArticle(Article $article): void
    {
        if ($this === $article->supplier()) {
            $this->articles->add($article);
        }
    }

    public function orderDays(): array
    {
        return $this->orderDays;
    }
}
