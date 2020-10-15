import {CountryEntity} from "../../country-entity";


export class CountriesResponse {
  public status: string;
  public countries: Array<CountryEntity>
  constructor() {
  }
}
