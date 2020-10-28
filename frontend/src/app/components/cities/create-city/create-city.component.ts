import {Component, OnInit} from '@angular/core';
import {CountryEntity} from "../../../entities/country-entity";
import {ActivatedRoute} from "@angular/router";
import {CountryService} from "../../../services/country/country.service";
import {CityService} from "../../../services/city/city.service";

@Component({
  selector: 'app-create-city',
  templateUrl: './create-city.component.html',
  styleUrls: ['./create-city.component.css']
})
export class CreateCityComponent implements OnInit {

  public country: CountryEntity = new CountryEntity();

  constructor(private router: ActivatedRoute, private countryService: CountryService, private cityService: CityService) {
  }

  ngOnInit(): void {
    this.setCountry();
  }

  private setCountry(): void {
    this.router.params.subscribe(async params => {
      await this.countryService.getCountry(params.countryUuid);
      this.country = this.countryService.getCountryResponse().country;
    })
  }
}
