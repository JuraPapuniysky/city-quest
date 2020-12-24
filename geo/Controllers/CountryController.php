<?php

declare(strict_types=1);

namespace Geo\Controllers;

use App\Exceptions\ValidationException;
use Geo\Factories\Response\CountryResponseFactory;
use Geo\Services\CountryService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CountryController
{
    private CountryService $countryService;
    private CountryResponseFactory $countryResponseFactory;

    public function __construct(CountryService $countryService, CountryResponseFactory $countryResponseFactory)
    {
        $this->countryService = $countryService;
        $this->countryResponseFactory = $countryResponseFactory;
    }

    public function countries(ServerRequestInterface $request): ResponseInterface
    {
        $countries = $this->countryService->getAllCountries();

        return $this->countryResponseFactory->countries($countries);
    }

    public function country(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $country = $this->countryService->getOneCountryByUuid($uuid);
        } catch (EntityNotFoundException $e) {
            return $this->countryResponseFactory->notFound($e);
        }

        return $this->countryResponseFactory->country($country);
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $country = $this->countryService->create($request);
        } catch (ValidationException $e) {
            return $this->countryResponseFactory->validationError($e);
        } catch (EntityNotFoundException $e) {
            return $this->countryResponseFactory->notFound($e);
        }

        return $this->countryResponseFactory->country($country);
    }

    public function update(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $country = $this->countryService->getOneCountryByUuid($uuid);

            $country = $this->countryService->update($request, $country);
        } catch (EntityNotFoundException $e) {
            return $this->countryResponseFactory->notFound($e);
        } catch (ValidationException $e) {
            return $this->countryResponseFactory->validationError($e);
        }

        return $this->countryResponseFactory->country($country);
    }

    public function search(ServerRequestInterface $request, string $prefix): ResponseInterface
    {
        $countryEntities = $this->countryService->search($prefix);

        return $this->countryResponseFactory->countries($countryEntities);
    }

    public function delete(ServerRequestInterface $request, $uuid): ResponseInterface
    {
        try {
            $country = $this->countryService->getOneCountryByUuid($uuid);
            $this->countryService->delete($country);
        } catch (EntityNotFoundException $e) {
            return $this->countryResponseFactory->notFound($e);
        }

        return $this->countryResponseFactory->deleted();
    }
}
