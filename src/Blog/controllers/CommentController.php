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
        $comment = new Comment();
        $postTitle = $request->getPost('postTitle');
        $comment->setPostTitle($postTitle);
        $comment->setAuthor($session->get('user')['name']);
        $comment->setText($request->getPost('text'));
        $comment->setCreatedDate(date('Y-m-d H:i:s'));
        $comment->save();

        $comment->load(array('author' => $session->get('user')['name'], 'created_date' => $comment->getCreatedDate()));
        $post = new Post(array('title' => $postTitle));
        $post->setAmountOfComments($post->getAmountOfComments() + 1);
        $post->save(array('title' => $postTitle));

        echo <<<HERE
            <img class="user-picture img-rounded" src="{$_SESSION['user']['picture']}" alt="user picture" />
            <div class="panel panel-default comment-block">
                <div class="panel-heading panel-title comment-title">
                    <p>{$comment->getAuthor()} says:</p>
                    <sub>{$comment->getCreatedDate()}</sub>
                    <div class="clear"></div>
                </div>
                <div class="panel-body comment-body">
                    {$comment->getText()}
                </div>
                <div class="panel-footer comment-footer">
                    <span class="comment-id">{$comment->getId()}</span>
                    <button type="button" class="btn btn-danger delete_comment_button" onclick="deleteComment(this)">Delete</button>
                </div>
            </div>
HERE;
    }

    public function deleteAction($id)
    {
        $id = func_get_args()[0][0];
        $comment = new Comment(array('id' => $id));
        $postTitle = $comment->getPostTitle();
        $comment->remove();

        $post = new Post(array('title' => $postTitle));
        $post->setAmountOfComments($post->getAmountOfComments() - 1);
        $post->save(array('title' => $postTitle));
    }
}