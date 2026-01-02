<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request)
    {
        $student = $request->user()->student;

        $booking = new Booking([
            'student_id' => $student,
            'tutor_id' => $request->input('tutor_id'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
        ]);

        $student->bookings()->save($booking);
    }
}
