<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProjectController;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome', ['isAdmin' => session('is_admin', false)]);
});

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $request->validate(['password' => 'required']);

    if ($request->password === config('app.admin_password')) {
        session(['is_admin' => true]);
        return redirect('/');
    }

    return back()->withErrors(['password' => 'Password salah.']);
})->name('admin.login.post');

Route::post('/admin/logout', function () {
    session()->forget('is_admin');
    return redirect('/');
})->name('admin.logout');

// Contact API
Route::post('/api/contact', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'subject' => 'required|string|max:200',
        'message' => 'required|string|max:2000',
    ]);

    $adminAddress = config('mail.admin_address') ?? config('mail.from.address');

    Mail::to($adminAddress)->send(new ContactMail(
        senderName:   $data['name'],
        senderEmail:  $data['email'],
        mailSubject:  $data['subject'],
        messageBody:  $data['message'],
    ));

    return response()->json(['message' => 'Sent']);
});

// Projects API
Route::get('/api/projects', [ProjectController::class, 'index']);
Route::post('/api/projects', [ProjectController::class, 'store']);
Route::post('/api/projects/{project}', [ProjectController::class, 'update']);
Route::delete('/api/projects/{project}', [ProjectController::class, 'destroy']);
