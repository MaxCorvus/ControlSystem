<?php
namespace Repository;
use Model\Comment;

class CommentRepository
{
    public function __construct(private DbConnection $dbConnection) {

    }
    public function save(Comment $comment) {
        $this->dbConnection->query("INSERT INTO `comment` (`name`, `text`, `created_at`, `post_id`) VALUES ('$comment->name', '$comment->text', '$comment->createdAt', '$comment->post_id')");
    }
    public function getComments(int $id):array
    {
        $sql = "SELECT * FROM `comment` WHERE post_id='$id';";
        return $this->dbConnection->query($sql)->loadObjectList();
    }
}