<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['space', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('start_time')
            ->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $spaces = Space::where('is_active', true)->get();
        return view('reservations.create', compact('spaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'space_id'   => 'required|exists:spaces,id',
            'start_time' => 'required|date|after:now',
            'end_time'   => 'required|date|after:start_time',
            'notes'      => 'nullable|string',
        ]);

        $conflict = Reservation::where('space_id', $request->space_id)
            ->where('status', '!=', 'Cancelada')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        if ($conflict) {
            return back()->withErrors([
                'start_time' => 'Este espaço já está reservado neste horário.'
            ])->withInput();
        }

        Reservation::create([
            'user_id'    => Auth::id(),
            'space_id'   => $request->space_id,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'status'     => 'Confirmada',
            'notes'      => $request->notes,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reserva realizada com sucesso!');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->update(['status' => 'Cancelada']);
        return redirect()->route('reservations.index')->with('success', 'Reserva cancelada com sucesso!');
    }

    public function edit(Reservation $reservation) {}
    public function update(Request $request, Reservation $reservation) {}
}