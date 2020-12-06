<?php

declare(strict_types=1);

namespace User\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;


/**
 * Class AbstractRepository
 * @package User\Model
 */
class AbstractRepository implements RepositoryInterface
{
    /**
     * @var AdapterInterface
     */
    private $db;
    /**
     * @var HydratorInterface
     */
    private $hydrator;
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var
     */
    private $entity;


    /**
     * AbstractRepository constructor.
     * @param AdapterInterface $db
     * @param string $tableName
     * @param HydratorInterface $hydrator
     * @param $entity
     */
    public function __construct(
        AdapterInterface    $db,
        string              $tableName,
        HydratorInterface   $hydrator,
        $entity
    ) {
        $this->db           = $db;
        $this->hydrator     = $hydrator;
        $this->tableName    = $tableName;
        $this->entity       = $entity;
    }

    /**
     * @param int $count
     * @param int $status
     * @param string $order
     * @return array|HydratingResultSet
     */
    public function getItems(
        $count = 10,
        $order = 'id ASC'
    ) {

        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableName);
        $select->order($order);
        $select->limit($count);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        return $this->resultSet($result);
    }

    /**
     * @param int $page
     * @param int $countPerPage
     * @param string $order
     * @return Paginator
     */
    public function getPaginator(
        int $page = 1,
        int $countPerPage = 20,
        string $order = 'id ASC'
    ) : Paginator {

        $sql    = new Sql($this->db);
        $select = $sql->select($this->tableName);

        $select->order($order);

        $paginator = $this->getPaginatorResultSet($select);
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(10);

        return $paginator;
    }

    /**
     * @param $id
     * @return object
     */
    public function getItem($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableName);
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        return $this->resultSet($result)->current();
    }

    /**
     * @param ResultInterface $result
     * @return array|HydratingResultSet
     */
    public function resultSet(ResultInterface $result)
    {
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
//            throw new RuntimeException(sprintf(
//                'Failed retrieving data with identifier "%s"; unknown database error.',
//                $id
//            ));
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->entity);
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     * @param Select $select
     * @return Paginator
     */
    public function getPaginatorResultSet(Select $select) : Paginator
    {
        $resultSet = new HydratingResultSet($this->getHydrator(), $this->getEntity());

        $adapter = new DbSelect($select, $this->getDb(), $resultSet);

        return new Paginator($adapter);
    }

    /**
     * @param $data
     * @param null $id
     * @return ResultInterface
     */
    public function saveItem($data, $id = null) : ResultInterface
    {
        if (!$id) {
            return $this->insertItem($data);
        }
        return $this->updateItem($data, $id);
    }

    /**
     * @param $data
     * @return ResultInterface
     */
    public function insertItem($data)
    {
        unset($data['id']);
        $sql    = new Sql($this->db);
        $insert = $sql->insert($this->tableName);

        $insert->values($this->prepareData($data));

        $statement = $sql->prepareStatementForSqlObject($insert);
        return $statement->execute();
    }

    /**
     * @param $data
     * @param $id
     * @return ResultInterface
     */
    public function updateItem($data, $id)
    {
        $sql    = new Sql($this->db);
        $update = $sql->update($this->tableName);

        $update->set($this->prepareData($data));
        $update->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($update);
        return $statement->execute();
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data) : array
    {
        unset($data['submit']);
        foreach ($data as $key => $val) {
            if ($val === false) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return AdapterInterface
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
