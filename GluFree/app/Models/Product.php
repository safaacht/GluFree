<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'category_id',
        'photo',
        'certificationSansGluten'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function fournisseurs(){
        return $this->belongsToMany(Fournisseur::class, 'fournisseurProduit', 'product_id', 'fournisseur_id')
                    ->withPivot('qteStock', 'prix')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favoris', 'product_id', 'user_id');
    }
}
