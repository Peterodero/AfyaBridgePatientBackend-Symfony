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

    #[ORM\Column(length: 50)]
    private string $role = 'patient';

    #[ORM\Column(length: 255)]
    private string $full_name;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password_hash;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $profile_image = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $initials = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $is_active = true;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $is_verified = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $two_factor_enabled = false;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $two_factor_method = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $two_factor_phone = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $last_password_change = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $last_login = null;

    #[ORM\Column(length: 50, options: ['default' => 'active'])]
    private string $account_status = 'active';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_reason = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $age = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $blood_type = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $provider_sharing = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $research_opt_in = false;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $emergency_contacts = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $allergies = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $surgeries = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $visits = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $conditions = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $documents = null;

    // Doctor/Specialist fields
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $specialty = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $kmpdc_license = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hospital = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $consultation_fee = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $allow_video_consultations = true;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $allow_in_person_consultations = true;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $working_hours = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $slot_duration = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $auto_confirm_appointments = false;

    #[ORM\Column(type: 'decimal', precision: 3, scale: 2, nullable: true)]
    private ?string $rating = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $total_reviews = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $verification_status = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $verified_at = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $verified_by = null;

    // Driver fields
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $national_id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $vehicle_type = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $plate_number = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $driving_license_no = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $license_expiry = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $id_verified = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $license_verified = false;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $approved_status = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $date_approved = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $on_duty = false;

    // Pharmacy fields
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $pharmacy_id = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $orders_made = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $verified_by_admin = false;

    // GPS coordinates
    #[ORM\Column(type: 'decimal', precision: 10, scale: 8, nullable: true)]
    private ?string $gps_lat = null;

    #[ORM\Column(type: 'decimal', precision: 11, scale: 8, nullable: true)]
    private ?string $gps_lng = null;

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
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self { $this->role = $role; return $this; }
    public function getFullName(): string { return $this->full_name; }
    public function setFullName(string $full_name): self { $this->full_name = $full_name; return $this; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPasswordHash(): string { return $this->password_hash; }
    public function setPasswordHash(string $password_hash): self { $this->password_hash = $password_hash; return $this; }
    public function getPassword(): string { return $this->password_hash; }
    public function setPassword(string $password): self { $this->password_hash = $password; return $this; }
    public function getPhoneNumber(): ?string { return $this->phone_number; }
    public function setPhoneNumber(?string $phone_number): self { $this->phone_number = $phone_number; return $this; }
    public function getProfileImage(): ?string { return $this->profile_image; }
    public function setProfileImage(?string $profile_image): self { $this->profile_image = $profile_image; return $this; }
    public function getInitials(): ?string { return $this->initials; }
    public function setInitials(?string $initials): self { $this->initials = $initials; return $this; }
    public function isActive(): bool { return $this->is_active; }
    public function setIsActive(bool $is_active): self { $this->is_active = $is_active; return $this; }
    public function isVerified(): bool { return $this->is_verified; }
    public function setIsVerified(bool $is_verified): self { $this->is_verified = $is_verified; return $this; }
    public function isTwoFactorEnabled(): bool { return $this->two_factor_enabled; }
    public function setTwoFactorEnabled(bool $two_factor_enabled): self { $this->two_factor_enabled = $two_factor_enabled; return $this; }
    public function getTwoFactorMethod(): ?string { return $this->two_factor_method; }
    public function setTwoFactorMethod(?string $two_factor_method): self { $this->two_factor_method = $two_factor_method; return $this; }
    public function getTwoFactorPhone(): ?string { return $this->two_factor_phone; }
    public function setTwoFactorPhone(?string $two_factor_phone): self { $this->two_factor_phone = $two_factor_phone; return $this; }
    public function getLastPasswordChange(): ?\DateTimeInterface { return $this->last_password_change; }
    public function setLastPasswordChange(?\DateTimeInterface $last_password_change): self { $this->last_password_change = $last_password_change; return $this; }
    public function getLastLogin(): ?\DateTimeInterface { return $this->last_login; }
    public function setLastLogin(?\DateTimeInterface $last_login): self { $this->last_login = $last_login; return $this; }
    public function getAccountStatus(): string { return $this->account_status; }
    public function setAccountStatus(string $account_status): self { $this->account_status = $account_status; return $this; }
    public function getStatusReason(): ?string { return $this->status_reason; }
    public function setStatusReason(?string $status_reason): self { $this->status_reason = $status_reason; return $this; }
    public function getBio(): ?string { return $this->bio; }
    public function setBio(?string $bio): self { $this->bio = $bio; return $this; }
    public function getGender(): ?string { return $this->gender; }
    public function setGender(?string $gender): self { $this->gender = $gender; return $this; }
    public function getDateOfBirth(): ?\DateTimeInterface { return $this->date_of_birth; }
    public function setDateOfBirth(?\DateTimeInterface $date_of_birth): self { $this->date_of_birth = $date_of_birth; return $this; }
    public function getAge(): ?int { return $this->age; }
    public function setAge(?int $age): self { $this->age = $age; return $this; }
    public function getBloodType(): ?string { return $this->blood_type; }
    public function setBloodType(?string $blood_type): self { $this->blood_type = $blood_type; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $address): self { $this->address = $address; return $this; }
    public function isProviderSharing(): bool { return $this->provider_sharing; }
    public function setProviderSharing(bool $provider_sharing): self { $this->provider_sharing = $provider_sharing; return $this; }
    public function isResearchOptIn(): bool { return $this->research_opt_in; }
    public function setResearchOptIn(bool $research_opt_in): self { $this->research_opt_in = $research_opt_in; return $this; }
    public function getEmergencyContacts(): ?array { return $this->emergency_contacts; }
    public function setEmergencyContacts(?array $emergency_contacts): self { $this->emergency_contacts = $emergency_contacts; return $this; }
    public function getAllergies(): ?array { return $this->allergies; }
    public function setAllergies(?array $allergies): self { $this->allergies = $allergies; return $this; }
    public function getSurgeries(): ?array { return $this->surgeries; }
    public function setSurgeries(?array $surgeries): self { $this->surgeries = $surgeries; return $this; }
    public function getVisits(): ?array { return $this->visits; }
    public function setVisits(?array $visits): self { $this->visits = $visits; return $this; }
    public function getConditions(): ?array { return $this->conditions; }
    public function setConditions(?array $conditions): self { $this->conditions = $conditions; return $this; }
    public function getDocuments(): ?array { return $this->documents; }
    public function setDocuments(?array $documents): self { $this->documents = $documents; return $this; }
    public function getSpecialty(): ?string { return $this->specialty; }
    public function setSpecialty(?string $specialty): self { $this->specialty = $specialty; return $this; }
    public function getKmpdcLicense(): ?string { return $this->kmpdc_license; }
    public function setKmpdcLicense(?string $kmpdc_license): self { $this->kmpdc_license = $kmpdc_license; return $this; }
    public function getHospital(): ?string { return $this->hospital; }
    public function setHospital(?string $hospital): self { $this->hospital = $hospital; return $this; }
    public function getConsultationFee(): ?string { return $this->consultation_fee; }
    public function setConsultationFee(?string $consultation_fee): self { $this->consultation_fee = $consultation_fee; return $this; }
    public function allowVideoConsultations(): bool { return $this->allow_video_consultations; }
    public function setAllowVideoConsultations(bool $allow_video_consultations): self { $this->allow_video_consultations = $allow_video_consultations; return $this; }
    public function allowInPersonConsultations(): bool { return $this->allow_in_person_consultations; }
    public function setAllowInPersonConsultations(bool $allow_in_person_consultations): self { $this->allow_in_person_consultations = $allow_in_person_consultations; return $this; }
    public function getWorkingHours(): ?array { return $this->working_hours; }
    public function setWorkingHours(?array $working_hours): self { $this->working_hours = $working_hours; return $this; }
    public function getSlotDuration(): ?int { return $this->slot_duration; }
    public function setSlotDuration(?int $slot_duration): self { $this->slot_duration = $slot_duration; return $this; }
    public function autoConfirmAppointments(): bool { return $this->auto_confirm_appointments; }
    public function setAutoConfirmAppointments(bool $auto_confirm_appointments): self { $this->auto_confirm_appointments = $auto_confirm_appointments; return $this; }
    public function getRating(): ?string { return $this->rating; }
    public function setRating(?string $rating): self { $this->rating = $rating; return $this; }
    public function getTotalReviews(): ?int { return $this->total_reviews; }
    public function setTotalReviews(?int $total_reviews): self { $this->total_reviews = $total_reviews; return $this; }
    public function getVerificationStatus(): ?string { return $this->verification_status; }
    public function setVerificationStatus(?string $verification_status): self { $this->verification_status = $verification_status; return $this; }
    public function getVerifiedAt(): ?\DateTimeInterface { return $this->verified_at; }
    public function setVerifiedAt(?\DateTimeInterface $verified_at): self { $this->verified_at = $verified_at; return $this; }
    public function getVerifiedBy(): ?string { return $this->verified_by; }
    public function setVerifiedBy(?string $verified_by): self { $this->verified_by = $verified_by; return $this; }
    public function getNationalId(): ?string { return $this->national_id; }
    public function setNationalId(?string $national_id): self { $this->national_id = $national_id; return $this; }
    public function getVehicleType(): ?string { return $this->vehicle_type; }
    public function setVehicleType(?string $vehicle_type): self { $this->vehicle_type = $vehicle_type; return $this; }
    public function getPlateNumber(): ?string { return $this->plate_number; }
    public function setPlateNumber(?string $plate_number): self { $this->plate_number = $plate_number; return $this; }
    public function getDrivingLicenseNo(): ?string { return $this->driving_license_no; }
    public function setDrivingLicenseNo(?string $driving_license_no): self { $this->driving_license_no = $driving_license_no; return $this; }
    public function getLicenseExpiry(): ?\DateTimeInterface { return $this->license_expiry; }
    public function setLicenseExpiry(?\DateTimeInterface $license_expiry): self { $this->license_expiry = $license_expiry; return $this; }
    public function isIdVerified(): bool { return $this->id_verified; }
    public function setIdVerified(bool $id_verified): self { $this->id_verified = $id_verified; return $this; }
    public function isLicenseVerified(): bool { return $this->license_verified; }
    public function setLicenseVerified(bool $license_verified): self { $this->license_verified = $license_verified; return $this; }
    public function getApprovedStatus(): ?string { return $this->approved_status; }
    public function setApprovedStatus(?string $approved_status): self { $this->approved_status = $approved_status; return $this; }
    public function getDateApproved(): ?\DateTimeInterface { return $this->date_approved; }
    public function setDateApproved(?\DateTimeInterface $date_approved): self { $this->date_approved = $date_approved; return $this; }
    public function isOnDuty(): bool { return $this->on_duty; }
    public function setOnDuty(bool $on_duty): self { $this->on_duty = $on_duty; return $this; }
    public function getPharmacyId(): ?array { return $this->pharmacy_id; }
    public function setPharmacyId(?array $pharmacy_id): self { $this->pharmacy_id = $pharmacy_id; return $this; }
    public function getOrdersMade(): ?array { return $this->orders_made; }
    public function setOrdersMade(?array $orders_made): self { $this->orders_made = $orders_made; return $this; }
    public function isVerifiedByAdmin(): bool { return $this->verified_by_admin; }
    public function setVerifiedByAdmin(bool $verified_by_admin): self { $this->verified_by_admin = $verified_by_admin; return $this; }
    public function getGpsLat(): ?string { return $this->gps_lat; }
    public function setGpsLat(?string $gps_lat): self { $this->gps_lat = $gps_lat; return $this; }
    public function getGpsLng(): ?string { return $this->gps_lng; }
    public function setGpsLng(?string $gps_lng): self { $this->gps_lng = $gps_lng; return $this; }
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
