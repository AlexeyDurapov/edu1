<?php

declare(strict_types=1);

namespace User\Model;

class CitiesRepository extends AbstractRepository implements CitiesRepositoryInterface
{
    const TABLE_NAME        = 'cities';
    const COUNT_PER_PAGE    = 50;

    public function getCitiesJson()
    {
        $items = $this->getItems(self::COUNT_PER_PAGE);
        $resultArray = [
            'success' => true,
        ];
        foreach ($items as $item) {
            $resultArray['items'][] = [
                'id' => $item->getId(),
                'name' => $item->getName()
                ];
        }

        return $resultArray;
    }
}
