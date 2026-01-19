<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Tutor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function index(Tutor $tutor): Response
    {
        $tutor->load('user');
        $student = auth()->user()->student;

        $bookings = Booking::query()
            ->where('tutor_id', $tutor->id)
            ->get(['id', 'start', 'end', 'status', 'student_id']);

        return Inertia::render('student/booking-page', [
            'tutor' => [
                'id' => $tutor->id,
                'name' => $tutor->user->name,
            ],
            'bookings' => $bookings->map(function ($booking) use ($student) {
                $isOwnBooking = $booking->student_id === $student->id;

                return [
                    'id' => (string) $booking->id,
                    'title' => $isOwnBooking ? ucfirst($booking->status) : 'Unavailable',
                    'start' => $booking->start->toIso8601String(),
                    'end' => $booking->end->toIso8601String(),
                    'color' => $isOwnBooking ? match ($booking->status) {
                        'confirmed' => '#10b981',
                        'pending' => '#f59e0b',
                        'canceled' => '#ef4444',
                        default => '#6b7280',
                    } : '#94a3b8', // Slate-400 for unavailable
                ];
            }),
        ]);
    }

    public function show(Booking $booking): Response
    {
        $this->authorize('view', $booking);

        $booking->load(['tutor.user', 'student.user', 'documents']);

        return Inertia::render('bookings/show', [
            'booking' => [
                'id' => $booking->id,
                'start' => $booking->start->toIso8601String(),
                'end' => $booking->end->toIso8601String(),
                'status' => $booking->status,
                'tutor' => [
                    'name' => $booking->tutor->user->name,
                    'image' => $booking->tutor->user->image,
                ],
                'student' => [
                    'name' => $booking->student->user->name,
                    'image' => $booking->student->user->image,
                ],
                'documents' => $booking->documents->map(fn ($doc) => [
                    'id' => $doc->id,
                    'filename' => $doc->filename,
                    'size' => $doc->size,
                    'created_at' => $doc->created_at->toIso8601String(),
                ]),
            ],
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $student = $request->user()->student;

        $booking = new Booking([
            'student_id' => $student->id,
            'tutor_id' => $request->input('tutor_id'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
        ]);

        $booking->save();

        return back();
    }
}
