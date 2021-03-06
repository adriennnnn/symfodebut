<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Campaign
 *
 * @ORM\Table(name="campaign")
 * @ORM\Entity
 */
class Campaign
{
    /**
     * @var Uuid
     * 
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * 
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=150, nullable=true, options={"default"="NULL"})
     */
    private $title = NULL;

    /**
     * @var string|null
     * 
     *           * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * ) 
     *
     *
     * @ORM\Column(name="content", type="text", length=5, nullable=true, options={"default"="NULL"})
     */
    private $content = NULL;

    /**
     * @var \DateTime|null
     * 
     *   *      @Assert\Length(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $createdAt = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $updatedAt = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="goal", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $goal = NULL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email ;
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=true, options={"default"="NULL"})
     */
    private $name = NULL;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="campaign")
     */
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }
    public function __toString()
    {
        $this->name;
        return $this->name;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
    public function setId(): self
    {
        $this->id = Uuid::v4();

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGoal(): ?int
    {
        return $this->goal;
    }

    public function setGoal(?int $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setCampaign($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getCampaign() === $this) {
                $participant->setCampaign(null);
            }
        }

        return $this;
    }
    public function getRecoltedAmount(): int {
        // ON RECUPERE ICI L'ARGENT RECOLTE DIRECTEMENT AVEC LA PROPRIETE PAYMENTS DE L'ENTITE PARTICIPANT
        // R??cup??rer tous les paiements de chaque participant de la campagne, et l'ajouter dans $payments
        $payments = [];
        foreach ($this->getParticipants() as $participant) {
            array_push($payments, ...$participant->getPayments());
        }

        // Calculer la somme de tous les paiements
        $sum = array_sum(array_map(function($payment) {
            return $payment->getAmount();
        }, $payments));

        return $sum;
    }
    public function getPourcent(): int {
        $goal = $this->getGoal();
        $recolted = $this->getRecoltedAmount();

        if($goal === 0){
            return 0;
        }
        return round (($recolted/$goal)*100);
        
    }



}