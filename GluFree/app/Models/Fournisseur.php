<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Fournisseur extends User
{
    protected $table = 'users';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('role', function (Builder $builder) {
            $builder->where('role', 'fournisseur');
        });
    }

    
    protected $attributes = [
        'role' => 'fournisseur',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
