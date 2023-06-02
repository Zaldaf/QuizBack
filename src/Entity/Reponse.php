<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_responses'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getQuestion','get_responses'])]
    private ?string $intituler = null;

    #[ORM\Column]
    #[Groups(['getQuestion','get_reponse_question'])]
    private ?bool $isCorrect = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[Groups(['get_responses'])]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituler(): ?string
    {
        return $this->intituler;
    }

    public function setIntituler(string $intituler): self
    {
        $this->intituler = $intituler;

        return $this;
    }

    public function isIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
