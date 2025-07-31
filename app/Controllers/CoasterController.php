<?php

namespace App\Controllers;

use App\Factories\Coaster\UpdateCoasterDTOFactory;
use App\Serializers\Coaster\CoasterSerializerResolver;
use App\Services\CoasterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Config\Services;
use RuntimeException;

class CoasterController extends ResourceController
{
    protected $format = 'json';

    protected CoasterService $service;
    protected CoasterSerializerResolver $resolver;

    public function initController($request, $response, $logger): void
    {
        parent::initController($request, $response, $logger);

        $this->service = Services::coasterService();
        $this->resolver = Services::registerCoasterSerializerResolver();
    }

    public function index(): ResponseInterface
    {
        $result = [];
        try {
            $coasters = $this->service->getAllCoasters();

            foreach ($coasters as $coaster) {
                $serializer = $this->resolver->resolve($coaster);
                $result[] = json_decode($serializer->serialize($coaster), true);
            }

            return $this->respond($result);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }


    public function create(): ResponseInterface
    {
        try {
            $json = $this->request->getBody();
            $dto = $this->resolver->getRegisterCoasterJsonSerializer()->deserialize($json);

            $this->service->registerCoaster($dto);

            return $this->respondCreated(['message' => 'Coaster registered']);
        } catch (RuntimeException $e) {
            return $this->fail($e->getMessage(), 400);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function show($id = null): ResponseInterface
    {
        try {
            $dto = $this->service->getCoaster($id);
            $json = $this->resolver->resolve($dto)->serialize($dto);

            return $this->respond(json_decode($json, true));
        } catch (RuntimeException $e) {
            return $this->failNotFound($e->getMessage());
        }
    }

    public function update($id = null): ResponseInterface
    {
        try {
            $json = $this->request->getBody();
            $dto = UpdateCoasterDTOFactory::create($id,json_decode($json, true));

            $this->service->updateCoaster($dto);

            return $this->respond(['message' => 'Coaster updated']);
        } catch (RuntimeException $e) {
            return $this->fail($e->getMessage(), 404);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function delete($id = null): ResponseInterface
    {
        try {
            $this->service->deleteCoaster($id);
            return $this->respondDeleted(['message' => 'Coaster deleted']);
        } catch (RuntimeException $e) {
            return $this->failNotFound($e->getMessage());
        }
    }
}
