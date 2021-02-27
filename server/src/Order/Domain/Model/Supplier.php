<?php

namespace Order\Domain\Model;

final class Supplier
{
    private string $name;
    private string $address;
    private string $email;
    private Articles $articles;

    public function __construct(string $name, string $address, string $email)
    {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->articles = new Articles();
    }

    public static function create(string $name, string $address, string $email): self
    {
        return new self($name, $address, $email);
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
}
