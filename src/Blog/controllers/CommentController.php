<?php

namespace Blog\Controllers;

use Blog\Models\Comment;
use Blog\Models\Post;
use Framework\Controller\Controller;

class CommentController extends Controller
{
    public function addAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->start();
        $comment   = new Comment();
        $postTitle = $request->getPost('postTitle');
        $comment->setPostTitle($postTitle);
        $comment->setAuthor($session->get('user')['name']);
        $comment->setText($request->getPost('text'));
        $comment->setCreatedDate(date('Y-m-d H:i:s'));
        $comment->save();

        $post = new Post(array('title' => $postTitle));
        $post->setAmountOfComments($post->getAmountOfComments() + 1);
        $post->save(array('title' => $postTitle));

        echo <<<HERE
            <div class="panel panel-default">
                <div class="panel-heading panel-title" style="font-size: 18px; padding: 10px 5px 0 5px;">
                    <p style="float: left;">{$comment->getAuthor()}</p>
                    <sub style='float: right; font-size: 12px; font-style: italic;'>{$comment->getCreatedDate()}</sub>
                    <div class="clear">
                </div>
                </div><div class="panel-body" style="text-align: left; padding: 20px;">
                    {$comment->getText()}
                </div>
                <div class="panel-footer" style="text-align: right; padding: 0;">
                    <button style="width: 70px; margin: 4px 2px" type="button" class="btn btn-danger delete_comment_button">Delete</button>
                </div>
            </div>
HERE;
    }

    public function deleteAction($id)
    {
        $id        = func_get_args()[0][0];
        $comment   = new Comment(array('id' => $id));
        $postTitle = $comment->getPostTitle();
        $comment->remove();

        $post = new Post(array('title' => $postTitle));
        $post->setAmountOfComments($post->getAmountOfComments() - 1);
        $post->save(array('title' => $postTitle));
    }
}