import { Component, OnInit } from '@angular/core';
import {CountryEntity} from "../../../entities/country-entity";
import {CountryService} from "../../../services/country/country.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-country-create',
  templateUrl: './country-create.component.html',
  styleUrls: ['./country-create.component.css']
})
export class CountryCreateComponent implements OnInit {

  public country: CountryEntity;

  constructor(private countryService: CountryService, private angularRouter: Router) {
    this.country = new CountryEntity();
  }

  ngOnInit(): void {
  }

  async createCountry(country: CountryEntity) {
    await this.countryService.createCountry(country);
    this.country = this.countryService.getCountryResponse().country;
    await this.angularRouter.navigate(['/country']);
  }
}
