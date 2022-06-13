<?php
namespace Repository;
use Model\Post;

class PostRepository
{
    public $posts;
    public function __construct(private DbConnection $dbConnection) {

    }
    public function save(Post $post) {

        $this->dbConnection->query("INSERT INTO `post` (`name`, `text`, `created_at`, `rate`, `rate_count`) VALUES ('$post->name', '$post->text', '$post->createdAt', '$post->rate', '$post->rateCount')");
    }
    public function update(Post $post) {
//
        $this->dbConnection->query("UPDATE `post` SET `name` = '$post->name', `text` = '$post->text', `created_at` = '$post->createdAt',`rate` = '$post->rate', `rate_count` = '$post->rateCount' WHERE id='$post->id'");
    }
    public function getPosts():array
    {
        $sql = "SELECT * FROM `post` ORDER BY created_at desc;";

        return $this->dbConnection->query($sql)->loadObjectList();
    }
    public function getPost(int $post_id):object
    {
        $sql = "SELECT * FROM `post` WHERE id='$post_id';";
         $postData = $this->dbConnection->query($sql)->loadObject();

         return new Post($postData['name'], $postData['text'], $postData['rate'], $postData['rate_count'],$postData['created_at'], $postData['id']);
    }
}