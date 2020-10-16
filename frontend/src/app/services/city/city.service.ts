import { Injectable } from '@angular/core';
import {environment} from "../../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {CountryEntity} from "../../entities/country-entity";
import {CitiesResponse} from "../../entities/Response/city/cities-response";

@Injectable({
  providedIn: 'root'
})
export class CityService {

  private apiUrl: string = environment.apiUrl;

  private $citiesResponse: CitiesResponse = new CitiesResponse();

  constructor(private httpClient: HttpClient) { }

  async getCitiesFromApi(country: CountryEntity) {
    return new Promise((resolve, reject) => {
      this.httpClient.request('GET', `${this.apiUrl}/cities/${country.uuid}`).toPromise()
        .then((data: CitiesResponse) => {
        this.$citiesResponse = data;
        resolve();
      }, error => {
        reject(error);
      });
    });
  }

  public getCitiesResponse(): CitiesResponse {
    return this.$citiesResponse
  }
}
