<?php

declare(strict_types=1);

namespace User\Handler;

use phpDocumentor\Reflection\Types\This;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use User\Model\EducationRepositoryInterface;
use User\Model\UserRepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Helper\UrlHelper;

class XhrHandler implements RequestHandlerInterface
{
    const ACTION_ALL_USERS      = 'allusers';
    const ACTION_UPDATE_USER    = 'userupdate';
    const ACTION_EDUCATION      = 'education';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var EducationRepositoryInterface
     */
    private $educationRepository;
    /**
     * @var UrlHelper
     */
    private $urlHelper;
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
        UrlHelper $urlHelper
    ) {
        $this->userRepository       = $userRepository;
        $this->educationRepository  = $educationRepository;
        $this->urlHelper            = $urlHelper;
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
                $response = $this->allUsersAction($data);
                break;

            case self::ACTION_EDUCATION:
                $response = $this->getEducationList();
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
    private function allUsersAction(?array $data)
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
     * @param array|null $data
     * @return bool[]
     */
    private function userUpdate(?array $data)
    {
        return $this->userRepository->userUpdate($data);
    }
}
