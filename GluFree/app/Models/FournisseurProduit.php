<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FournisseurProduit extends Model
{
    protected $table = 'fournisseurProduit';
    
    protected $fillable = [
        'fournisseur_id',
        'product_id',
        'qteStock',
        'prix'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(User::class, 'fournisseur_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
