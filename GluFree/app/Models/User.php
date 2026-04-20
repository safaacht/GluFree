<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tel',
        'cin',
        'ice',
        'city_id',
        'status',
        'password_confirmation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favoris()
    {
        return $this->belongsToMany(Product::class, 'favoris', 'user_id', 'product_id');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Product::class, 'fournisseurProduit', 'fournisseur_id', 'product_id')
                    ->withPivot('qteStock', 'prix')
                    ->withTimestamps();
    }

    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    // public function isClient()
    // {
    //     return $this->role === 'client';
    // }

    // public function isFournisseur()
    // {
    //     return $this->role === 'fournisseur';
    // }

}
