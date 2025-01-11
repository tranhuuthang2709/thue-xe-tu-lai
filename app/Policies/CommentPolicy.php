<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any comments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // Nếu bạn muốn tất cả người dùng có thể xem bình luận
        return true;
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        // Kiểm tra quyền xem bình luận (tùy thuộc vào yêu cầu của bạn)
        return true;
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        // Chỉ cho phép người dùng chỉnh sửa bình luận của chính họ
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        // Chỉ cho phép người dùng xóa bình luận của chính họ
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment)
    {
        // Nếu cần tính năng phục hồi bình luận đã xóa, kiểm tra quyền ở đây
        return false;
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment)
    {
        // Kiểm tra quyền xóa vĩnh viễn bình luận (nếu có)
        return false;
    }
}
