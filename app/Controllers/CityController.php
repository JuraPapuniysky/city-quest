<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Factories\Response\CityResponseFactory;
use App\Services\CityService;
use App\Services\CountryService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CityController
{
    private CityService $cityService;
    private CountryService $countryService;
    private CityResponseFactory $cityResponseFactory;

    public function __construct(
        CityService $cityService,
        CityResponseFactory $cityResponseFactory,
        CountryService $countryService
    ) {
        $this->cityService = $cityService;
        $this->cityResponseFactory = $cityResponseFactory;
        $this->countryService = $countryService;
    }

    public function city(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $city = $this->cityService->getCityByUuid($uuid);
        } catch (EntityNotFoundException $e) {
            return $this->cityResponseFactory->notFound($e);
        }

        return $this->cityResponseFactory->city($city);
    }

    public function cities(ServerRequestInterface $request, $countryUuid): ResponseInterface
    {
        try {
            $country = $this->countryService->getOneCountryByUuid($countryUuid);
            $cities = $this->cityService->getCitiesByCountry($country);
        } catch (EntityNotFoundException $e) {
            return $this->cityResponseFactory->notFound($e);
        }

        return $this->cityResponseFactory->cities($cities);
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $city = $this->cityService->create($request);
        } catch (ValidationException $e) {
            return $this->cityResponseFactory->validationError($e);
        }

        return $this->cityResponseFactory->city($city, 201);
    }

    public function update(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $city = $this->cityService->getCityByUuid($uuid);
            $city = $this->cityService->update($request, $city);
        } catch (ValidationException $e) {
            return $this->cityResponseFactory->validationError($e);
        } catch (EntityNotFoundException $e) {
            return $this->cityResponseFactory->notFound($e);
        }

        return $this->cityResponseFactory->city($city, 201);
    }

    public function delete(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $cityEntity = $this->cityService->getCityByUuid($uuid);
            $this->cityService->delete($cityEntity);
        } catch (EntityNotFoundException $e) {
            return $this->cityResponseFactory->notFound($e);
        }

        return $this->cityResponseFactory->deleted();
    }
}