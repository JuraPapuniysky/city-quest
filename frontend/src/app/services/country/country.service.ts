import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from "../../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class CountryService {

  private apiUrl: string = environment.apiUrl;

  constructor(private httpClient: HttpClient) { }

  public getCountries() {
    return this.httpClient.request('GET', `${this.apiUrl}/countries`);
  }

  public getCountry(uuid: string) {
    return this.httpClient.request('GET', `${this.apiUrl}/country/${uuid}`);
  }
}
