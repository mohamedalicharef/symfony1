<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
    * @ORM\Entity(repositoryClass=UserRepository::class)
    * @UniqueEntity(
    * fields={"email"},
    * message="L'émail que vous avez tapé est déjà utilisé !"
    * )
    * @ORM\InheritanceType("JOINED")
    * @ORM\DiscriminatorColumn(name="type", type="string")
    * @ORM\DiscriminatorMap({
    *     "admine" = "Admin",
    *     "apprenant" = "Apprenant",
    *     "tuteur" = "Tuteur"
    * })
    */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
      * @ORM\Column(type="string", length=255)
      * @Assert\Length(
      *    min = 8,
      *    minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
      */
    private $password;
    /**
      * @Assert\EqualTo(propertyPath = "password",
      * message="Vous n'avez pas saisi le même mot de passe !" )
      */
    private $confirm_password;
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }
    public function setConfirmPassword($confirm_password)
    {
        $this->confirm_password = $confirm_password;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = $this->roles;
// garantit que chaque utilisateur possède le rôle ROLE_USER
// équivalent à array_push() qui ajoute un élément au tabeau
        $roles[] = 'ROLE_USER';
//array_unique élémine des doublons
        return array_unique($roles);
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etatCompte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cin;

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEtatCompte(): ?bool
    {
        return $this->etatCompte;
    }

    public function setEtatCompte(?bool $etatCompte): self
    {
        $this->etatCompte = $etatCompte;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }


}
