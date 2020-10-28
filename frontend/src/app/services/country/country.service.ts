import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {environment} from "../../../environments/environment";
import {CountriesResponse} from "../../entities/Response/country/countries-response";
import {CountryResponse} from "../../entities/Response/country/country-response";
import {CountryEntity} from "../../entities/country-entity";
import {rejects} from "assert";


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

  async createCountry(country: CountryEntity) {
    return new Promise((resolve, reject) => {
      let headers = new HttpHeaders();
      headers.append('Content-Type', 'application/json');
      headers.append('Access-Control-Allow-Origin', '*');

      this.httpClient.post(`${this.apiUrl}/country`, country, {headers: headers}).toPromise()
        .then((data: CountryResponse) => {
          this.countryResponse = data;
          resolve();
        }, error => {
          reject(error);
        });
    })
  }

  async updateCountry(country: CountryEntity) {
    return new Promise((resolve, reject) => {
      this.httpClient.put(`${this.apiUrl}/country/${country.uuid}`, country).toPromise()
        .then((data: CountryResponse) => {
          this.countryResponse = data;
          resolve();
      }, error => {
        reject(error);
      });
    });
  }

  public deleteCountry(country: CountryEntity) {
    return this.httpClient.delete(`${this.apiUrl}/country/${country.uuid}`);
  }
}
