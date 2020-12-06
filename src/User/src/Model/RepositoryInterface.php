<?php


namespace User\Model;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Paginator\Paginator;

/**
 * Interface RepositoryInterface
 * @package User\Model
 */
interface RepositoryInterface
{
    public function getItems();
    public function getItem($id);
    public function getPaginator(int $page, int $countPerPage, string $order) : Paginator;
    public function saveItem($data, $id) : ResultInterface;


}
