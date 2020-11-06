import {Component, OnInit} from '@angular/core';
import {CountryEntity} from "../../../entities/country-entity";
import {ActivatedRoute, Router} from "@angular/router";
import {CountryService} from "../../../services/country/country.service";
import {CityService} from "../../../services/city/city.service";
import {CityEntity} from "../../../entities/city-entity";

@Component({
  selector: 'app-create-city',
  templateUrl: './city-create.component.html',
  styleUrls: ['./city-create.component.css']
})
export class CityCreateComponent implements OnInit {

  public country: CountryEntity = new CountryEntity();
  public city: CityEntity = new CityEntity();

  constructor(
    private router: ActivatedRoute,
    private countryService: CountryService,
    private cityService: CityService,
    private angularRouter: Router
  ) {
  }

  ngOnInit(): void {
    this.setCountry();
  }

  private setCountry(): void {
    this.router.params.subscribe(async params => {
      await this.countryService.getCountry(params.countryUuid);
      this.country = this.countryService.getCountryResponse().country;
      this.city.countryUuid = this.country.uuid;
    })
  }

  async createCity(city: CityEntity) {
    await this.cityService.createCity(city);
    this.city = this.cityService.getCityResponse().city;
    await this.angularRouter.navigate(['/cities', this.city.countryUuid]);
  }
}
