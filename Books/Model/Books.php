<?php
namespace Max\Books\Model;

use Magento\Framework\Model\AbstractModel;
use Max\Books\Api\Data\BooksInterface;
use Max\Books\Model\ResourceModel\ResourceBooks;

class Books extends AbstractModel implements BooksInterface
{
    protected function _construct()
    {
        $this->_init(ResourceBooks::class);
    }
    public function getId()
    {
        return $this->getData(self::BOOK_ID);
    }

    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getVolume()
    {
        return $this->getData(self::VOLUME);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
    public function setId($id)
    {
        return $this->setData(self::BOOK_ID, $id);
    }
    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
    public function setVolume($volume)
    {
        return $this->setData(self::VOLUME, $volume);
    }
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
