import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from "../../../environments/environment";
import {CountriesResponse} from "../../entities/Response/country/countries-response";
import {CountryResponse} from "../../entities/Response/country/country-response";


@Injectable({
  providedIn: 'root'
})
export class CountryService {

  private apiUrl: string = environment.apiUrl;

  private countriesResponse: CountriesResponse = new CountriesResponse();

  private countryResponse: CountryResponse = new CountryResponse();

  constructor(private httpClient: HttpClient) { }

  async getCountries() {
    return new Promise((resolve, reject) => {
      this.httpClient.request('GET', `${this.apiUrl}/countries`).toPromise()
        .then((data: CountriesResponse) => {
          this.countriesResponse = data;
        resolve();
      }, error => {
        reject(error);
      });
    })
  }

  public getCountriesResponse(): CountriesResponse {
    return this.countriesResponse;
  }

  async getCountry(uuid: string) {
    return new Promise((resolve, reject) => {
      this.httpClient.request('GET', `${this.apiUrl}/country/${uuid}`).toPromise()
        .then((data: CountryResponse) => {
        this.countryResponse = data;
        resolve();
      }, error => {
          reject(error);
        });
    })
  }

  public getCountryResponse(): CountryResponse {
    return this.countryResponse;
  }
}
