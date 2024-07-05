<?php

namespace App\Models;

use App\Interface\ImageOwnerInterface;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Zus1\Discriminator\Observers\DiscriminatorObserver;
use Zus1\LaravelAuth\Trait\Token;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property string $email
 * @property string $password
 * @property array $roles
 * @property int $active
 * @property string $employed_at
 * @property int $identifier
 * @property int $social_security_number
 * @property string $seniority
 */
#[Attributes([
    ['id',
        'librarian:register', 'librarian:collection', 'librarian:retrieve',
        'librarian:toggleActive', 'imageOwner:nestedImageUpload'
    ],
    ['email', 'librarian:register', 'librarian:retrieve'],
    ['first_name', 'librarian:register', 'librarian:collection', 'librarian:retrieve'],
    ['last_name', 'librarian:register', 'librarian:collection', 'librarian:retrieve'],
    ['city', 'librarian:register', 'librarian:retrieve'],
    ['dob', 'librarian:register', 'librarian:retrieve'],
    ['roles', 'librarian:register'],
    ['employed_at', 'librarian:register', 'librarian:retrieve'],
    ['identifier', 'librarian:register', 'librarian:collection', 'librarian:retrieve'],
    ['social_security_number', 'librarian:register', 'librarian:collection', 'librarian:retrieve'],
    ['seniority', 'librarian:register', 'librarian:collection', 'librarian:retrieve'],
    ['active', 'librarian:collection', 'librarian:retrieve', 'librarian:toggleActive'],
    ['images', 'librarian:retrieve']
])]
#[ObservedBy(DiscriminatorObserver::class)]
class Librarian extends User implements ImageOwnerInterface
{
    use HasFactory, Notifiable, Token;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function searchableFields(): array
    {
        return [
            'roles',
            'parent.first_name',
            'parent.last_name',
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'roles' => 'array',
            'password' => 'hashed',
            'active' => 'bool'
        ];
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'image_owner');
    }
}
