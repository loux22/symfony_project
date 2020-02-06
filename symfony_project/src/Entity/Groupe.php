<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Error;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Error\Length(min=3, minMessage="ton username '{{ value }}' est trop court")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo = 'default.jpg';

    private $file;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="groupes")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groupes")
     */
    private $users_p;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="groupe")
     */
    private $messages;



    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(user $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }
    }


    public function removeUser(user $user)
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }
    }




    public function getUsersP(): ?user
    {
        return $this->users_p;
    }

    public function setUsersP(?user $users_p): self
    {
        $this->users_p = $users_p;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setGroupe($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getGroupe() === $this) {
                $message->setGroupe(null);
            }
        }

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this -> file = $file;
        return $this;
    }

    public function dirFile()
    {
        return __DIR__ . '/../../public/images/groupe/';
    }

    public function fileUpload()
    {
        if($this -> file  != null){
            $newName = $this -> renameFile($this -> file -> getClientOriginalName());
            $this -> photo = $newName;
            $this -> file -> move($this->dirFile(),$newName);
        }
    }

    public function renameFile($nom)
    {
        return 'photo_' . time() . '_' . rand(1,99999) . '_' . $nom;
    }

    public function removeFile()
    {
        if(file_exists($this->dirFile() . $this-> photo) && $this-> photo != 'default.jpg'){
            unlink($this->dirFile() . $this-> photo);
        }
        
    }
}
