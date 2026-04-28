<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'published' => Post::query()->where('status', 'published')->count(),
            'drafts' => Post::query()->where('status', 'draft')->count(),
            'services' => Service::query()->count(),
            'courses' => Course::query()->count(),
            'users' => User::query()->count(),
            'unreviewedMessages' => ContactMessage::query()->whereNull('reviewed_at')->count(),
            'totalMessages' => ContactMessage::query()->count(),
        ];

        $recentPosts = Post::query()->latest()->take(5)->get();
        $recentServices = Service::query()->latest('updated_at')->take(4)->get();
        $recentCourses = Course::query()->latest('updated_at')->take(4)->get();
        $latestMessages = ContactMessage::query()->latest()->take(6)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'recentServices' => $recentServices,
            'recentCourses' => $recentCourses,
            'latestMessages' => $latestMessages,
        ]);
    }

    public function messages(): View
    {
        $messages = ContactMessage::query()->latest()->paginate(12);

        return view('admin.messages', [
            'messages' => $messages,
        ]);
    }

    public function markMessageAsReviewed(ContactMessage $contactMessage): RedirectResponse
    {
        if (! $contactMessage->reviewed_at) {
            $contactMessage->update([
                'reviewed_at' => now(),
            ]);
        }

        return back()->with('status', __('Mensaje marcado como revisado.'));
    }
}