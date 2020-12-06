<?php

declare(strict_types=1);

namespace User\Model;

class EducationRepository extends AbstractRepository implements EducationRepositoryInterface
{
    const TABLE_NAME        = 'education';
    const COUNT_PER_PAGE    = 50;

    public function getEducationJson()
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
