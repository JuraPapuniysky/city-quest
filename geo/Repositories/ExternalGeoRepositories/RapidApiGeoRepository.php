<?php

declare(strict_types=1);

namespace Geo\Repositories\ExternalGeoRepositories;

use App\Entities\CountryEntity;
use App\Entities\Request\CityRequestEntity;
use App\Entities\Request\CountryRequestEntity;
use Geo\Exceptions\ExternalServiceException;
use Geo\Factories\Entity\CityEntityFactory;
use Geo\Factories\Entity\CountryEntityFactory;
use Geo\Repositories\CityRepositoryInterface;
use Geo\Repositories\CountryRepositoryInterface;

class RapidApiGeoRepository implements CountryRepositoryInterface, CityRepositoryInterface
{
    const RAPID_API_KEY = 'rWARmZOj1zmsh8kqfbIXxenylDV0p1THdwXjsn2iSftfxkGY9X';
    const RAPID_API_HOST = 'wft-geo-db.p.rapidapi.com';
    const GET_COUNTRY_URL = 'https://wft-geo-db.p.rapidapi.com/v1/geo/countries/{%countryIsoCode%}';
    const GET_COUNTRIES_URL = 'https://wft-geo-db.p.rapidapi.com/v1/geo/countries?';
    const GET_CITY_URL = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities?';

    public function __construct(
        private CountryEntityFactory $countryEntityFactory,
        private CityEntityFactory $cityEntityFactory
    ) {

    }

    public function getCountries(string $prefix, int $count): array
    {
        $query = http_build_query(['namePrefix' => $prefix]);

        $url = self::GET_COUNTRIES_URL . $query;

        $responseObject = json_decode($this->createRequest($url));

        $countryGeoEntities = [];
        foreach ($responseObject->data as $country) {
            $countryGeoEntity = new CountryRequestEntity();
            $countryGeoEntity->isoCode = $country->code;
            $countryGeoEntity->name = $country->name;


            $countryEntity = $this->countryEntityFactory->create($countryGeoEntity);
            $countryGeoEntities[] = $countryEntity;
        }

        return $countryGeoEntities;
    }

    public function getCities(CountryEntity $countryEntity, string $prefix, int $count): array
    {
        $params = [];
        if (!empty($countryCode)) {
            $params['countryIds'] = $countryCode;
        }

        $params['namePrefix'] = $prefix;

        $query = http_build_query($params);
        $url = self::GET_CITY_URL . $query;

        $responseObject = json_decode(utf8_encode($this->createRequest($url)));

        $cityEntities = [];

        foreach ($responseObject->data as $city) {
            $cityRequestEntity = new CityRequestEntity();
            $cityRequestEntity->countryUuid = $countryEntity->getUuid();
            $cityRequestEntity->name = $city->name;

            $cityEntity = $this->cityEntityFactory->create($cityRequestEntity);
            $cityEntities[] = $cityEntity;
        }


        return $cityEntities;
    }

    private function createRequest(string $url): string
    {
        sleep(1);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-rapidapi-host: " . self::RAPID_API_HOST,
                "x-rapidapi-key: " . self::RAPID_API_KEY
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            throw new ExternalServiceException('GeoDbCity service error' . $err . ' url: ' . $url . 'response: ' . $response);
        }

        curl_close($curl);

        return $response;
    }
}
