import { Injectable } from '@angular/core';
import {environment} from "../../../environments/environment";
import {HttpClient} from "@angular/common/http";
import {CountryEntity} from "../../entities/country-entity";

@Injectable({
  providedIn: 'root'
})
export class CityService {

  private apiUrl: string = environment.apiUrl;

  constructor(private httpClient: HttpClient) { }

  public getCities(country: CountryEntity) {
    return this.httpClient.request('GET', `${this.apiUrl}/cities/${country.uuid}`);
  }

}
