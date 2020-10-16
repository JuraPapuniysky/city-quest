import { Component, OnInit } from '@angular/core';
import {CountryService} from "../../services/country/country.service";
import {ActivatedRoute} from "@angular/router";
import {CountryEntity} from "../../entities/country-entity";

@Component({
  selector: 'app-country',
  templateUrl: './country.component.html',
  styleUrls: ['./country.component.css']
})
export class CountryComponent implements OnInit {

  tableHeader = ['Uuid', 'Name' ,'Iso Code', 'Description', ''];
  public countries: Array<CountryEntity> = [];

  constructor(private countryService: CountryService, private router: ActivatedRoute) { }

  async ngOnInit() {
    await this.countryService.getCountries();
    this.countries = this.countryService.getCountriesResponse().countries;
  }

}
