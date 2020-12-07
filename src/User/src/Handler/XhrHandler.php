<?php

declare(strict_types=1);

namespace User\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use User\Model\CitiesRepositoryInterface;
use User\Model\EducationRepositoryInterface;
use User\Model\UserRepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;

class XhrHandler implements RequestHandlerInterface
{
    const ACTION_ALL_USERS      = 'allusers';
    const ACTION_UPDATE_USER    = 'userupdate';
    const ACTION_EDUCATION      = 'education';
    const ACTION_SITIES         = 'cities';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var EducationRepositoryInterface
     */
    private $educationRepository;
    /**
     * @var CitiesRepositoryInterface
     */
    private $citiesRepository;
    /**
     * @var int|mixed
     */
    private $page;
    /**
     * @var int
     */
    private $countPerPage;

    public function __construct(
        UserRepositoryInterface  $userRepository,
        EducationRepositoryInterface $educationRepository,
        CitiesRepositoryInterface $citiesRepository
    ) {
        $this->userRepository       = $userRepository;
        $this->educationRepository  = $educationRepository;
        $this->citiesRepository     = $citiesRepository;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = $request->getQueryParams();

        if ($request->getMethod() === 'POST') {
            $data['data'] = json_decode(file_get_contents('php://input'));
        }

        $action = $data['action'] ?? null;

        $this->page = $data['page'] ?? 1;
        $this->countPerPage = $data['limit'] ?? 1;

        switch ($action) {
            case self::ACTION_ALL_USERS:
                $response = $this->allUsersAction();
                break;

            case self::ACTION_EDUCATION:
                $response = $this->getEducationList();
                break;

            case self::ACTION_SITIES:
                $response = $this->getSitiesList();
                break;

            case self::ACTION_UPDATE_USER:
                $response = $this->userUpdate($data);
                break;

            default:
                $response = null;
        }

        return new JsonResponse(
            $response
        );
    }

    /**
     * @param array|null $data
     * @return array
     */
    private function allUsersAction()
    {
        return $this->userRepository->getUsersJson(
            (int) $this->page,
            (int) $this->countPerPage
        );
    }

    /**
     * @return bool[]
     */
    private function getEducationList()
    {
        return $this->educationRepository->getEducationJson();
    }

    /**
     * @return bool[]
     */
    private function getSitiesList()
    {
        return $this->citiesRepository->getCitiesJson();
    }

    /**
     * @param array|null $data
     * @return bool[]
     */
    private function userUpdate(?array $data)
    {
        return $this->userRepository->userUpdate($data);
    }
}
