<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentController extends Controller
{
    // Content validation constants
    private const MIN_CONTENT_LENGTH = 3;
    private const MAX_CONTENT_LENGTH = 500;

    // Permission constants
    private const ADMIN_ROLE = 'admin';

    // Error messages
    private const ERROR_UNAUTHORIZED = 'Anda tidak memiliki izin untuk menghapus komentar ini.';
    private const ERROR_COMMENT_NOT_FOUND = 'Komentar tidak ditemukan.';
    private const ERROR_CREATE_FAILED = 'Gagal menambahkan komentar. Silakan coba lagi.';
    private const ERROR_DELETE_FAILED = 'Gagal menghapus komentar. Silakan coba lagi.';

    // Success messages
    private const SUCCESS_COMMENT_ADDED = 'Komentar berhasil ditambahkan.';
    private const SUCCESS_COMMENT_DELETED = 'Komentar berhasil dihapus.';

    /**
     * Store a newly created comment in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validate input data
            $validatedData = $this->validateCommentData($request);

            // Begin database transaction
            DB::beginTransaction();

            // Create comment with validated data
            $comment = $this->createComment($validatedData);

            // Commit transaction
            DB::commit();

            // Log successful comment creation
            $this->logCommentAction('created', $comment->id, Auth::id());

            return redirect()->back()->with('success', self::SUCCESS_COMMENT_ADDED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->validator)
                           ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create comment', [
                'user_id' => Auth::id(),
                'post_id' => $request->input('post_id'),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->with('error', self::ERROR_CREATE_FAILED)
                           ->withInput();
        }
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        try {
            // Check if comment exists
            if (!$this->commentExists($comment)) {
                return redirect()->back()->with('error', self::ERROR_COMMENT_NOT_FOUND);
            }

            // Check user permissions
            if (!$this->canDeleteComment($comment)) {
                $this->logUnauthorizedAction('delete_comment', $comment->id, Auth::id());
                return redirect()->back()->with('error', self::ERROR_UNAUTHORIZED);
            }

            // Begin database transaction
            DB::beginTransaction();

            // Store comment info for logging before deletion
            $commentId = $comment->id;
            $commentUserId = $comment->user_id;

            // Delete the comment
            $comment->delete();

            // Commit transaction
            DB::commit();

            // Log successful comment deletion
            $this->logCommentAction('deleted', $commentId, Auth::id(), $commentUserId);

            return redirect()->back()->with('success', self::SUCCESS_COMMENT_DELETED);

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', self::ERROR_COMMENT_NOT_FOUND);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete comment', [
                'comment_id' => $comment->id ?? null,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', self::ERROR_DELETE_FAILED);
        }
    }

    /**
     * Validate comment input data.
     *
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateCommentData(Request $request): array
    {
        return $request->validate([
            'post_id' => 'required|string|max:255', // External API post ID
            'content' => 'required|string|min:' . self::MIN_CONTENT_LENGTH . '|max:' . self::MAX_CONTENT_LENGTH,
        ], [
            'post_id.required' => 'Post ID diperlukan.',
            'post_id.string' => 'Post ID harus berupa string.',
            'post_id.max' => 'Post ID terlalu panjang.',
            'content.required' => 'Konten komentar diperlukan.',
            'content.string' => 'Konten komentar harus berupa teks.',
            'content.min' => 'Konten komentar minimal ' . self::MIN_CONTENT_LENGTH . ' karakter.',
            'content.max' => 'Konten komentar maksimal ' . self::MAX_CONTENT_LENGTH . ' karakter.',
        ]);
    }

    /**
     * Create a new comment with validated data.
     *
     * @param array $validatedData
     * @return Comment
     */
    private function createComment(array $validatedData): Comment
    {
        return Comment::create([
            'post_id' => $validatedData['post_id'],
            'user_id' => Auth::id(),
            'content' => trim($validatedData['content']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Check if the authenticated user can delete the comment.
     *
     * @param Comment $comment
     * @return bool
     */
    private function canDeleteComment(Comment $comment): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // User can delete their own comment or admin can delete any comment
        return $user->id === $comment->user_id || $this->isAdmin($user);
    }

    /**
     * Check if the user has admin role.
     *
     * @param User $user
     * @return bool
     */
    private function isAdmin(User $user): bool
    {
        return $user->role === self::ADMIN_ROLE;
    }

    /**
     * Check if comment exists and is accessible.
     *
     * @param Comment|null $comment
     * @return bool
     */
    private function commentExists(?Comment $comment): bool
    {
        return $comment !== null && $comment->exists;
    }

    /**
     * Log comment actions for audit trail.
     *
     * @param string $action
     * @param int $commentId
     * @param int $userId
     * @param int|null $originalUserId
     * @return void
     */
    private function logCommentAction(string $action, int $commentId, int $userId, ?int $originalUserId = null): void
    {
        $logData = [
            'action' => $action,
            'comment_id' => $commentId,
            'user_id' => $userId,
            'timestamp' => now()->toDateTimeString(),
        ];

        if ($originalUserId && $originalUserId !== $userId) {
            $logData['original_user_id'] = $originalUserId;
            $logData['admin_action'] = true;
        }

        Log::info("Comment {$action}", $logData);
    }

    /**
     * Log unauthorized access attempts.
     *
     * @param string $action
     * @param int $commentId
     * @param int $userId
     * @return void
     */
    private function logUnauthorizedAction(string $action, int $commentId, int $userId): void
    {
        Log::warning('Unauthorized comment action attempted', [
            'action' => $action,
            'comment_id' => $commentId,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
