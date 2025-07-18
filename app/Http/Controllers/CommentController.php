<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'post_id' => 'required|string', // Changed to string since it's from external API
            'content' => 'required|string|max:500|min:3',
        ]);

        Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        if (!$this->canDeleteComment($comment)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    private function canDeleteComment(Comment $comment): bool
    {
        return Auth::id() === $comment->user_id || (Auth::user()->role ?? null) === 'admin';
    }
}
