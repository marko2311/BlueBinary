<?php

namespace App\Controllers;

use App\Constants\WagonFields;
use App\Serializers\Wagon\WagonSerializerResolver;
use App\Services\WagonService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Config\Services;
use RuntimeException;

class WagonController extends ResourceController
{
    protected $format = 'json';

    protected WagonService $service;
    protected WagonSerializerResolver $resolver;

    public function initController($request, $response, $logger): void
    {
        parent::initController($request, $response, $logger);

        $this->service = Services::wagonService();
        $this->resolver = Services::registerWagonSerializerResolver();
    }

    public function create($coasterId = null): ResponseInterface
    {
        if ($coasterId === null) {
            return $this->failValidationErrors('Missing coaster ID');
        }

        try {
            $json = (string) $this->request->getBody();
            $data = json_decode($json, true);
            $data[WagonFields::COASTER_ID] = $coasterId;
            $json = json_encode($data, JSON_THROW_ON_ERROR);

            $dto = $this->resolver
                ->getRegisterWagonJsonSerializer()
                ->deserialize($json);

            $this->service->registerWagon($coasterId, $dto);

            return $this->respondCreated(['message' => "Wagon registered to coaster $coasterId"]);
        } catch (RuntimeException $e) {
            return $this->fail($e->getMessage(), 400);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function delete($coasterId = null, $wagonId = null): ResponseInterface
    {
        if ($coasterId === null || $wagonId === null) {
            return $this->failValidationErrors('Missing coaster or wagon ID');
        }

        try {
            $this->service->deleteWagon($coasterId, $wagonId);
            return $this->respondDeleted(['message' => "Wagon $wagonId deleted from coaster $coasterId"]);
        } catch (RuntimeException $e) {
            return $this->failNotFound($e->getMessage());
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
