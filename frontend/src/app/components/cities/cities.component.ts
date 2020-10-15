import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {CountryService} from "../../services/country/country.service";
import {CountryResponse} from "../../entities/Response/country/country-response";
import {CountryEntity} from "../../entities/country-entity";
import {CityEntity} from "../../entities/city-entity";
import {CityService} from "../../services/city/city.service";
import {CitiesResponse} from "../../entities/Response/city/cities-response";

@Component({
  selector: 'app-cities',
  templateUrl: './cities.component.html',
  styleUrls: ['./cities.component.css']
})
export class CitiesComponent implements OnInit {

  public tableHeader: Array<string> = ['uuid', 'name', 'description', ''];
  public country: CountryEntity = new CountryEntity();
  public cities: Array<CityEntity>

  constructor(private router: ActivatedRoute, private countryService: CountryService, private cityService: CityService) {
  }

  ngOnInit(): void {
    this.router.params.subscribe(params => {
      let countryUuid = params.countryUuid;
      this.countryService.getCountry(countryUuid).subscribe((data: CountryResponse) => {
        this.country = data.country
        this.cityService.getCities(this.country).subscribe((data: CitiesResponse) => {
          this.cities = data.cities;
        })
      });
    });
  }
}
