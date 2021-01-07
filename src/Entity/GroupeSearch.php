<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class GroupeSearch
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe")
     */
    private $groupe;
    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }
    public function setCategory(?Category $groupe): self
    {
        $this->groupe = $groupe;
        return $this;
    }
}