<?php

use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ShoppingCartController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [UserController::class, 'createUser']);
Route::post('auth/login', [UserController::class, 'loginUser']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::middleware('auth:sanctum')->post('/articles', [ArticleController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/articles/{id}', [ArticleController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/categories', [ArticleCategoryController::class, 'index']);

Route::middleware('auth:sanctum')->get('/shoppingcart', [ShoppingCartController::class, 'index']);
Route::middleware('auth:sanctum')->post('/shoppingcart/{id}', [ShoppingCartController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', [ShoppingCartController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/testlink', [ArticleController::class, 'testlink']);

