<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\UserContoller;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Auht
Route::controller(RegisterController::class)->group(function(){
    Route::get('/register','create')->name('register.create');
    Route::post('/register','store')->name('register.store');

});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login','create')->name('login');
    Route::post('/login','store')->name('login.store');
    Route::post('/logout','destroy')->name('logout');

});

// Fournisseur
Route::middleware(['auth', 'fournisseur'])->group(function () {
    Route::resource('fournisseur', FournisseurController::class);
    Route::resource('product', ProductController::class)->except(['index', 'show']);

    // Fournisseur — commandes 
    Route::get('/fournisseur-commandes', [FournisseurController::class, 'commandes'])->name('fournisseur.commandes');
    Route::patch('/commande/{commande}/accepter', [CommandeController::class, 'accepter'])->name('commande.accepter');
});

// Visiteur
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');


// Client
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserContoller::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserContoller::class, 'updateProfile'])->name('profile.update');

    // Favoris
    Route::get('/favoris', [FavorisController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{product}', [FavorisController::class, 'store'])->name('favoris.store');
    Route::delete('/favoris/{product}', [FavorisController::class, 'destroy'])->name('favoris.destroy');

    // Panier
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/add/{product}', [PanierController::class, 'add'])->name('panier.add');
    Route::patch('/panier/{key}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/panier/{key}', [PanierController::class, 'remove'])->name('panier.remove');

    // Commande
    Route::get('/commande', [CommandeController::class, 'index'])->name('commande.index');
    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');

});


// Admin,
Route::middleware('admin')->group(function() {
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/fournisseur/{fournisseur}/accept', [AdminController::class,'acceptFournisseur'])->name('admin.fournisseur.accept');
    Route::patch('/admin/fournisseur/{fournisseur}/refuser', [AdminController::class,'refuserFournisseur'])->name('admin.fournisseur.refuser');
    Route::delete('/admin/product/{product}', [AdminController::class,'deleteProduct'])->name('admin.product.delete');
});

