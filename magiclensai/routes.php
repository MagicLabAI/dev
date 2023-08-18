<?php
use Illuminate\Support\Facades\Route;
use MagicLensAI\Controllers\MagicLensAIController;
use App\Http\Controllers\AIController;

//thenextleg API
Route::middleware('auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath',)->group(function () {
    Route::get('dashboard/user/magiclensai/generator/{slug}',[MagicLensAIController::class, 'index'])->name('dashboard.user.magiclensai.generator');
    Route::post('dashboard/user/magiclensai/generate',[MagicLensAIController::class, 'generateAIRequest']);
    Route::get('dashboard/user/magiclensai/generate/{messageId}/{id?}/{loadBalanceId?}',[MagicLensAIController::class, 'checkAIProgress']);
    Route::get('dashboard/user/magiclensai/image/delete/{id}',[MagicLensAIController::class, 'imageDelete'])->name('dashboard.user.magiclensai.image.delete');
    Route::post('dashboard/user/magiclensai/button',[MagicLensAIController::class, 'upscaleImages']);
    Route::post('dashboard/user/magiclensai/bad-words-filter',[MagicLensAIController::class, 'badWordsFilter']);
    Route::get('/download-image', [AIController::class, 'downloadImage'])->name('download.image');
});

?>