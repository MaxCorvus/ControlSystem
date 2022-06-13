<?php
namespace Routes;
use Model\Comment;
use Model\Post;
use Repository\CommentRepository;
use Repository\PostRepository;
use Repository\DbConnection;


class Controller
{
    public static function addPost(){
        $post = new Post($_POST['name'], $_POST['text']);
        $repository = new PostRepository(new DbConnection());
        $repository->save($post);
    }
    public static function getPosts(){
        $postRepository = new PostRepository(new DbConnection());
        $posts = $postRepository->getPosts();
        $commentRepository = new CommentRepository(new DbConnection());
        foreach ($posts as &$post) {
            $post['comments'] = $commentRepository->getComments($post['id']);
        }
        return json_encode($posts);

    }
    public static function addComment(){
        $comment = new Comment($_POST['post_id'], $_POST['name'], $_POST['text']);
        $repository = new CommentRepository(new DbConnection());
        $repository->save($comment);
    }
    public static function addRate() {
        $postRepository = new PostRepository(new DbConnection());
        $post = $postRepository->getPost($_POST['post_id']);
        $post->calcRate($_POST['value']);
        $postRepository->update($post);
    }
}