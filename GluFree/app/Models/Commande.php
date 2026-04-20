<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_general',
        'status',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items (fournisseur_produit) in this order.
     */
    public function items()
    {
        return $this->belongsToMany(FournisseurProduit::class, 'ProduitCommander', 'commande_id', 'fournisseur_produit_id')
                    ->withPivot('qte', 'total_commande')
                    ->withTimestamps();
    }
}
