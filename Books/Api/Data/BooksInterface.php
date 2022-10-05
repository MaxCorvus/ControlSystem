<?php
namespace Max\Books\Api\Data;

interface BooksInterface {
    const BOOK_ID      = 'book_id';
    const AUTHOR    = 'author';
    const NAME         = 'name';
    const VOLUME       = 'volume';
    const CREATED_AT = 'created_at';
    const UPDATED_AT   = 'updated_at';

    public function getId();
    public function getAuthor();
    public function getName();
    public function getVolume();
    public function getCreatedAt();
    public function getUpdatedAt();
    public function setId($id);
    public function setAuthor($author);
    public function setName($name);
    public function setVolume($volume);
    public function setCreatedAt($createdAt);
    public function setUpdatedAt($updatedAt);
}
