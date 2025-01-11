<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addcomment(Request $request, $car_id)
    {
        $data = [
            'content' => $request->input('content'),
            'car_id' => $car_id,
            'user_id' => auth()->user()->id
        ];
        Comment::create($data);
        return redirect()->back()->with('success', 'Thêm bình luận thành công');
    }
    public function edit(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('success', 'Sửa bình luận thành công');
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Xóa bình luận thành công');
    }
}
