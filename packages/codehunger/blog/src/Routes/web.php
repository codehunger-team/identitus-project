<?php

use Codehunger\Blog\Http\Controllers\BlogCategoryController;
use Codehunger\Blog\Http\Controllers\BlogController;
use Codehunger\Blog\Http\Controllers\BlogSlugController;
use Codehunger\Blog\Http\Controllers\FrontBlogController;
use Illuminate\Support\Facades\Route;
use Codehunger\Blog\Http\Controllers\SubcategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'auth', 'isAdmin'], 'prefix' => 'admin/blog'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/create', [BlogController::class, 'create'])->name('admin.blog.create');
    Route::post('blog/getsubcategory', [BlogController::class, 'getsubcategory'])->name('admin.blog.getsubcategory');
    Route::post('/store', [BlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/update/{blog}', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::post('/delete/{blog}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::post('create-slug', [BlogSlugController::class, 'createSlug'])->name('admin.blog.slug.create');
    Route::post('check-slug', [BlogSlugController::class, 'checkAvailability'])->name('admin.blog.slug.check');
});

Route::group(['middleware' => ['web', 'auth', 'isAdmin'], 'prefix' => 'admin/blog/category'], function () {
    Route::get('/', [BlogCategoryController::class, 'index'])->name('admin.blog.category.index');
    Route::post('/store', [BlogCategoryController::class, 'store'])->name('admin.blog.category.store');
    Route::post('/edit/{category}', [BlogCategoryController::class, 'edit'])->name('admin.blog.category.edit');
    Route::post('/update/{category}', [BlogCategoryController::class, 'update'])->name('admin.blog.category.update');
    Route::post('/delete/{category}', [BlogCategoryController::class, 'destroy'])->name('admin.blog.category.destroy');
});

Route::group(['middleware' => ['web', 'auth', 'isAdmin'], 'prefix' => 'admin/subcategory'], function () {
    Route::get('/', [SubcategoryController::class, 'index'])->name('admin.subcategory.index');
    Route::post('/store', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::post('/update/{subcategory}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::get('/edit/{subcategory}', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::post('/delete/{subcategory}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');
});

/* ----- This route group is used for front Knowledgebase ----- */
Route::prefix('blog')->group(function () {
    Route::get('/', [FrontBlogController::class, 'index'])->name('blog.index');
    Route::get('/{category}/{subcategory}/{slug}', [FrontBlogController::class, 'articleShow'])->name('frontknowledgebase.article.show');
    Route::get('/{fullslug}', function () {
    })->name('frontknowledgebase.slug.maker');
    Route::post('/search', [FrontBlogController::class, 'search'])->name('frontknowledgebase.subCategory.search');
    Route::post('reaction', [FrontBlogController::class, 'reaction'])->name('frontknowledgebase.reaction');
    Route::get('/category/{category}', [FrontBlogController::class, 'categoryShow'])->name('frontknowledgebase.category.show');
    Route::get('sub-category/{subcategory}', [FrontBlogController::class, 'subCategoryShow'])->name('frontknowledgebase.subCategory.show');
});
