<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    $data = [
        'totalSpaces'        => \App\Models\Space::where('is_active', true)->count(),
        'myReservations'     => \App\Models\Reservation::where('user_id', $user->id)->count(),
        'activeReservations' => $user->is_admin
            ? \App\Models\Reservation::where('status', 'confirmed')->count()
            : \App\Models\Reservation::where('user_id', $user->id)->where('status', 'confirmed')->count(),
        'totalReservations'  => \App\Models\Reservation::count(),
        'spaces'             => \App\Models\Space::where('is_active', true)->latest()->take(5)->get(),
        'recentReservations' => \App\Models\Reservation::with('space')->where('user_id', $user->id)->latest()->take(5)->get(),
    ];

    if ($user->is_admin) {
        $data['allReservations']        = \App\Models\Reservation::with(['space', 'user'])->latest()->take(8)->get();
        $data['activeReservationsList'] = \App\Models\Reservation::with(['space', 'user'])->where('status', 'confirmed')->get();
        $data['totalUsers']             = \App\Models\User::count();
        $data['users']                  = \App\Models\User::all();
    }

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/spaces', [SpaceController::class, 'index'])->name('spaces.index');
    Route::get('/spaces/create', [SpaceController::class, 'create'])->name('spaces.create')->middleware('can:admin');
    Route::get('/spaces/{space}', [SpaceController::class, 'show'])->name('spaces.show');

    Route::middleware('can:admin')->group(function () {
        Route::post('/spaces', [SpaceController::class, 'store'])->name('spaces.store');
        Route::get('/spaces/{space}/edit', [SpaceController::class, 'edit'])->name('spaces.edit');
        Route::put('/spaces/{space}', [SpaceController::class, 'update'])->name('spaces.update');
        Route::delete('/spaces/{space}', [SpaceController::class, 'destroy'])->name('spaces.destroy');
    });

    Route::resource('reservations', ReservationController::class);
});

require __DIR__.'/auth.php';