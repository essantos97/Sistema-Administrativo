<?php

use App\Http\Controllers\AuthEmpresa\AuthenticatedSessionController;
use App\Http\Controllers\AuthEmpresa\ConfirmablePasswordController;
use App\Http\Controllers\AuthEmpresa\EmailVerificationNotificationController;
use App\Http\Controllers\AuthEmpresa\EmailVerificationPromptController;
use App\Http\Controllers\AuthEmpresa\NewPasswordController;
use App\Http\Controllers\AuthEmpresa\PasswordResetLinkController;
use App\Http\Controllers\AuthEmpresa\RegisteredUserController;
use App\Http\Controllers\AuthEmpresa\VerifyEmailController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/empresa/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('empresa.register');

Route::post('/empresa/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

Route::get('/empresa/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('empresa.login');

Route::post('/empresa/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/empresa/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('empresa.password.request');

Route::post('/empresa/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('empresa.password.email');

Route::get('/empresa/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('empresa.password.reset');

Route::post('/empresa/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('empresa.password.update');

Route::get('/empresa/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth:empresa')
                ->name('empresa.verification.notice');

Route::get('/empresa/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth:empresa', 'signed', 'throttle:6,1'])
                ->name('empresa.verification.verify');

Route::post('/empresa/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth:empresa', 'throttle:6,1'])
                ->name('empresa.verification.send');

Route::get('/empresa/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth:empresa')
                ->name('empresa.password.confirm');

Route::post('/empresa/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth:empresa');

Route::post('/empresa/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:empresa')
                ->name('empresa.logout');
