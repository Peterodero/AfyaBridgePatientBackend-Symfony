<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password_hash;

    #[ORM\Column(length: 255)]
    private string $full_name;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 50)]
    private string $role = 'patient';

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $profile_image_url = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $profile_image_public_id = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 50, options: ['default' => 'active'])]
    private string $account_status = 'active';

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $is_verified = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $two_fa_enabled = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $last_password_change = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $last_login = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $blood_type = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $data_sharing_enabled = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emergency_contact_name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $emergency_contact_phone = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $emergency_contact_relationship = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $allergies = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $conditions = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $emergency_contacts = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $surgeries = null;

    // Doctor/Specialist fields
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $specialty = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hospital = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $consultation_fee = null;

    #[ORM\Column(type: 'decimal', precision: 3, scale: 2, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $total_reviews = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $slot_duration = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $allow_video_consultations = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $allow_in_person_consultations = true;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updated_at;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RefreshToken::class, cascade: ['remove'])]
    private Collection $refreshTokens;

    public function __construct()
    {
        $this->id = \Symfony\Component\Uid\Uuid::v4()->toRfc4122();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->refreshTokens = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTime();
    }

    // Getters and Setters
    public function getId(): string { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPassword(): string { return $this->password_hash; }
    public function getPasswordHash(): string { return $this->password_hash; }
    public function setPassword(string $password): self { $this->password_hash = $password; return $this; }
    public function setPasswordHash(string $password_hash): self { $this->password_hash = $password_hash; return $this; }
    public function getFullName(): string { return $this->full_name; }
    public function setFullName(string $full_name): self { $this->full_name = $full_name; return $this; }
    public function getPhoneNumber(): ?string { return $this->phone_number; }
    public function setPhoneNumber(?string $phone_number): self { $this->phone_number = $phone_number; return $this; }
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self { $this->role = $role; return $this; }
    public function getProfileImageUrl(): ?string { return $this->profile_image_url; }
    public function setProfileImageUrl(?string $profile_image_url): self { $this->profile_image_url = $profile_image_url; return $this; }
    public function getProfileImagePublicId(): ?string { return $this->profile_image_public_id; }
    public function setProfileImagePublicId(?string $profile_image_public_id): self { $this->profile_image_public_id = $profile_image_public_id; return $this; }
    public function getBio(): ?string { return $this->bio; }
    public function setBio(?string $bio): self { $this->bio = $bio; return $this; }
    public function getAccountStatus(): string { return $this->account_status; }
    public function setAccountStatus(string $account_status): self { $this->account_status = $account_status; return $this; }
    public function isVerified(): bool { return $this->is_verified; }
    public function setIsVerified(bool $is_verified): self { $this->is_verified = $is_verified; return $this; }
    public function isTwoFaEnabled(): bool { return $this->two_fa_enabled; }
    public function setTwoFaEnabled(bool $two_fa_enabled): self { $this->two_fa_enabled = $two_fa_enabled; return $this; }
    public function getLastPasswordChange(): ?\DateTimeInterface { return $this->last_password_change; }
    public function setLastPasswordChange(?\DateTimeInterface $last_password_change): self { $this->last_password_change = $last_password_change; return $this; }
    public function getLastLogin(): ?\DateTimeInterface { return $this->last_login; }
    public function setLastLogin(?\DateTimeInterface $last_login): self { $this->last_login = $last_login; return $this; }
    public function getGender(): ?string { return $this->gender; }
    public function setGender(?string $gender): self { $this->gender = $gender; return $this; }
    public function getDateOfBirth(): ?\DateTimeInterface { return $this->date_of_birth; }
    public function setDateOfBirth(?\DateTimeInterface $date_of_birth): self { $this->date_of_birth = $date_of_birth; return $this; }
    public function getBloodType(): ?string { return $this->blood_type; }
    public function setBloodType(?string $blood_type): self { $this->blood_type = $blood_type; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $address): self { $this->address = $address; return $this; }
    public function isSharingEnabled(): bool { return $this->data_sharing_enabled; }
    public function setSharingEnabled(bool $data_sharing_enabled): self { $this->data_sharing_enabled = $data_sharing_enabled; return $this; }
    public function getEmergencyContactName(): ?string { return $this->emergency_contact_name; }
    public function setEmergencyContactName(?string $emergency_contact_name): self { $this->emergency_contact_name = $emergency_contact_name; return $this; }
    public function getEmergencyContactPhone(): ?string { return $this->emergency_contact_phone; }
    public function setEmergencyContactPhone(?string $emergency_contact_phone): self { $this->emergency_contact_phone = $emergency_contact_phone; return $this; }
    public function getEmergencyContactRelationship(): ?string { return $this->emergency_contact_relationship; }
    public function setEmergencyContactRelationship(?string $emergency_contact_relationship): self { $this->emergency_contact_relationship = $emergency_contact_relationship; return $this; }
    public function getAllergies(): ?array { return $this->allergies; }
    public function setAllergies(?array $allergies): self { $this->allergies = $allergies; return $this; }
    public function getConditions(): ?array { return $this->conditions; }
    public function setConditions(?array $conditions): self { $this->conditions = $conditions; return $this; }
    public function getEmergencyContacts(): ?array { return $this->emergency_contacts; }
    public function setEmergencyContacts(?array $emergency_contacts): self { $this->emergency_contacts = $emergency_contacts; return $this; }
    public function getSurgeries(): ?array { return $this->surgeries; }
    public function setSurgeries(?array $surgeries): self { $this->surgeries = $surgeries; return $this; }
    public function getSpecialty(): ?string { return $this->specialty; }
    public function setSpecialty(?string $specialty): self { $this->specialty = $specialty; return $this; }
    public function getHospital(): ?string { return $this->hospital; }
    public function setHospital(?string $hospital): self { $this->hospital = $hospital; return $this; }
    public function getConsultationFee(): ?string { return $this->consultation_fee; }
    public function setConsultationFee(?string $consultation_fee): self { $this->consultation_fee = $consultation_fee; return $this; }
    public function getRating(): ?string { return $this->rating; }
    public function setRating(?string $rating): self { $this->rating = $rating; return $this; }
    public function getTotalReviews(): ?int { return $this->total_reviews; }
    public function setTotalReviews(?int $total_reviews): self { $this->total_reviews = $total_reviews; return $this; }
    public function getSlotDuration(): ?int { return $this->slot_duration; }
    public function setSlotDuration(?int $slot_duration): self { $this->slot_duration = $slot_duration; return $this; }
    public function allowVideoConsultations(): bool { return $this->allow_video_consultations; }
    public function setAllowVideoConsultations(bool $allow_video_consultations): self { $this->allow_video_consultations = $allow_video_consultations; return $this; }
    public function allowInPersonConsultations(): bool { return $this->allow_in_person_consultations; }
    public function setAllowInPersonConsultations(bool $allow_in_person_consultations): self { $this->allow_in_person_consultations = $allow_in_person_consultations; return $this; }
    public function getCreatedAt(): \DateTimeInterface { return $this->created_at; }
    public function getUpdatedAt(): \DateTimeInterface { return $this->updated_at; }
    public function setUpdatedAt(\DateTimeInterface $updated_at): self { $this->updated_at = $updated_at; return $this; }
    public function getRefreshTokens(): Collection { return $this->refreshTokens; }
    
    public function addRefreshToken(RefreshToken $refreshToken): self
    {
        if (!$this->refreshTokens->contains($refreshToken)) {
            $this->refreshTokens->add($refreshToken);
            $refreshToken->setUser($this);
        }
        return $this;
    }

    public function removeRefreshToken(RefreshToken $refreshToken): self
    {
        if ($this->refreshTokens->removeElement($refreshToken)) {
            if ($refreshToken->getUser() === $this) {
                $refreshToken->setUser(null);
            }
        }
        return $this;
    }

    // UserInterface implementation
    public function getUserIdentifier(): string { return $this->email; }
    
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];
        
        if ($this->role === 'admin') {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->role === 'specialist' || $this->role === 'doctor') {
            $roles[] = 'ROLE_SPECIALIST';
        } elseif ($this->role === 'pharmacy') {
            $roles[] = 'ROLE_PHARMACY';
        } elseif ($this->role === 'driver') {
            $roles[] = 'ROLE_DRIVER';
        }
        
        return $roles;
    }

    public function eraseCredentials(): void {}
}
