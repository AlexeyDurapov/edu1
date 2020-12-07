<?php

declare(strict_types=1);

namespace User\Model;

use stdClass;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Paginator;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    const TABLE_NAME            = 'users';
    const TABLE_EDUCATION_NAME  = 'education';
    const TABLE_CITIES_NAME     = 'cities';
    const TABLE_USER_CITY_NAME  = 'user_city';
    const TABLE_ORDER_DEFAULT   = 'id ASC';
    const COUNT_PER_PAGE        = 25;

    private $successResponse = true;

    /**
     * @param int $page
     * @param int $countPerPage
     * @param string $order
     * @return Paginator
     */
    public function getPaginator(
        int $page = 1,
        int $countPerPage = self::COUNT_PER_PAGE,
        string $order = self::TABLE_ORDER_DEFAULT
    ) : Paginator {

        $sql    = new Sql(parent::getDb());
        $select = $this->allUserInfoSelect($sql->select(self::TABLE_NAME));
        $select->order($order);

        $paginator = $this->getPaginatorResultSet($select);
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage($countPerPage);

        return $paginator;
    }

    /**
     * @param int $count
     * @param string $order
     * @return array|\Zend\Db\ResultSet\HydratingResultSet
     */
    public function getItems(
        $count = self::COUNT_PER_PAGE,
        $order = self::TABLE_ORDER_DEFAULT
    ) {
        $sql    = new Sql(parent::getDb());
        $select = $this->allUserInfoSelect($sql->select(self::TABLE_NAME));
        $select->order($order);
        $select->limit($count);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        return $this->resultSet($result);
    }

    /**
     * @param Select $select
     * @return Select
     */
    private function allUserInfoSelect(Select $select): Select
    {
        $select->columns([
            'id',
            'name'
        ]);
        $select->join(
            self::TABLE_EDUCATION_NAME,
            new Predicate\Expression(self::TABLE_NAME . '.education_id = ' . self::TABLE_EDUCATION_NAME . '.id'),
            [
                'eduid' => 'id',
                'education' => 'name'
            ],
            Join::JOIN_LEFT
        );
        $select->join(
            self::TABLE_USER_CITY_NAME,
            new Predicate\Expression(self::TABLE_USER_CITY_NAME . '.user_id=' .self::TABLE_NAME . '.id'),
            [],
            Join::JOIN_LEFT
        );
        $select->join(
            self::TABLE_CITIES_NAME,
            new Predicate\Expression(self::TABLE_USER_CITY_NAME. '.city_id'.'='. self::TABLE_CITIES_NAME . '.id'),
            [
                'cities' => new Predicate\Expression("GROUP_CONCAT(`cities`.`name` SEPARATOR ', ')")
            ],
            Join::JOIN_LEFT
        );

        $select->group('users.id');

        return $select;
    }

    /**
     * @param int $page
     * @param int $countPerPage
     * @return array
     */
    public function getUsersJson(int $page, int $countPerPage)
    {
        $items = $this->getPaginator($page, $countPerPage);
        $resultArray = [
            'success' => $this->successResponse,
            'totalCount' => $items->getTotalItemCount(),
        ];
        foreach ($items as $item) {
            $resultArray['data'][] = [
                'id'        => $item->getId(),
                'name'      => $item->getName(),
                'eduid'     => $item->getEduId(),
                'education' => $item->getEducation(),
                'cities'    => $item->getCities(),
                ];
        }

        return $resultArray;
    }

    /**
     * @param array|null $data
     * @return bool[]
     */
    public function userUpdate(?array $data)
    {
        if (is_array($data) && array_key_exists('data', $data)) {
            $newUserData = $data['data'];
            if (is_array($newUserData)) {
                foreach ($newUserData as $item) {
                    $this->updateUserInfo($item->data);
                }
            } else {
                $this->updateUserInfo($newUserData->data);
            }
        }

        return [
            'success' => $this->successResponse,
        ];
    }

    /**
     * @param $newUserData
     * @return false|ResultInterface
     */
    private function updateUserInfo($newUserData)
    {
        if ($newUserData instanceof stdClass) {
            if (($newUserData->eduid ?? false) && ($newUserData->id ?? false)) {
                return $this->saveItem(
                    [
                        'education_id' => $newUserData->eduid
                    ],
                    $newUserData->id
                );
            }
        }
        return $this->successResponse = false;
    }
}
