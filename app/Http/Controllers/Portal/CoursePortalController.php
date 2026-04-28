<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\View;

class CoursePortalController extends Controller
{
    public function index(): View
    {
        return view('portal.courses.index', [
            'courses' => Course::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get(),
        ]);
    }

    public function show(Course $course): View
    {
        abort_if($course->status !== 'published', 404);

        return view('portal.courses.show', [
            'course' => $course,
            'joinUrl' => data_get($course->googleMeetData(), 'meet_url'),
        ]);
    }
}