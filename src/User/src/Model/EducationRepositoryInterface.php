<?php


namespace User\Model;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Paginator\Paginator;

interface EducationRepositoryInterface
{
    public function getItems(int $count, string $order);
    public function getItem($id);
    public function getPaginator(int $page, int $countPerPage, string $order) : Paginator;
    public function saveItem($data, $id) : ResultInterface;
}
