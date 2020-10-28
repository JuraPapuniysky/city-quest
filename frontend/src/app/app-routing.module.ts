import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {CountryComponent} from "./components/country/country.component";
import {HomeComponent} from "./components/home/home.component";
import {CityComponent} from "./components/cities/city/city.component";
import {CitiesComponent} from "./components/cities/cities.component";
import {CreateCityComponent} from "./components/cities/create-city/create-city.component";
import {CountryCreateComponent} from "./components/country/country-create/country-create.component";
import {CountryUpdateComponent} from "./components/country/country-update/country-update.component";


const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'country', component: CountryComponent},
  {path: 'country/create', component: CountryCreateComponent},
  {path: 'country/update/:uuid', component: CountryUpdateComponent},
  {path: 'cities/:countryUuid', component: CitiesComponent},
  {path: 'city/:uuid', component: CityComponent},
  {path: 'city/create/:countryUuid', component: CreateCityComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
