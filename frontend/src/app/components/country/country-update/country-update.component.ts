import { Component, OnInit } from '@angular/core';
import {CountryEntity} from "../../../entities/country-entity";
import {ActivatedRoute, Router} from "@angular/router";
import {CountryService} from "../../../services/country/country.service";

@Component({
  selector: 'app-country-update',
  templateUrl: './country-update.component.html',
  styleUrls: ['./country-update.component.css']
})
export class CountryUpdateComponent implements OnInit {

  public country: CountryEntity = new CountryEntity();

  constructor(private router: ActivatedRoute, private angularRouter: Router, private countryService: CountryService) {}

  ngOnInit(): void {
    this.setData();
  }

  setData() {
    this.router.params.subscribe(async params => {
      await this.countryService.getCountry(params.uuid);
      this.country = this.countryService.getCountryResponse().country;
    });
  }

  async updateCountry(country: CountryEntity) {
    await this.countryService.updateCountry(country);
    this.country = this.countryService.getCountryResponse().country;
    await this.angularRouter.navigate(['/country']);
  }
}
