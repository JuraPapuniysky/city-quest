import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {CountryService} from "../../services/country/country.service";
import {CountryEntity} from "../../entities/country-entity";
import {CityEntity} from "../../entities/city-entity";
import {CityService} from "../../services/city/city.service";

@Component({
  selector: 'app-cities',
  templateUrl: './cities.component.html',
  styleUrls: ['./cities.component.css']
})
export class CitiesComponent implements OnInit {

  public tableHeader: Array<string> = ['uuid', 'name', 'description', ''];
  public country: CountryEntity = new CountryEntity();
  public cities: Array<CityEntity>;
  private countryUuid: string = '';

  constructor(private router: ActivatedRoute, private countryService: CountryService, private cityService: CityService) {
  }

  async ngOnInit() {
    this.setData();
  }

  setData() {
    this.router.params.subscribe(async params => {
      this.countryUuid = params.countryUuid;
      await this.countryService.getCountry(this.countryUuid);
      this.country = this.countryService.getCountryResponse().country;
      await this.cityService.getCitiesFromApi(this.country);
      this.cities = this.cityService.getCitiesResponse().cities
    });
  }
}
