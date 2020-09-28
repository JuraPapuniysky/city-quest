<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Factories\Response\CountryResponseFactory;
use App\Services\CountryService;
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

    public function country(ServerRequestInterface $request): ResponseInterface
    {
        $countries = $this->countryService->getAllCountries();

        return $this->countryResponseFactory->countries($countries);
    }

    public function countries(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        $country = $this->countryService->getOneCountryByUuid($uuid);

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