import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {CountryComponent} from "./components/country/country.component";
import {HomeComponent} from "./components/home/home.component";
import {CityComponent} from "./components/city/city.component";
import {CitiesComponent} from "./components/cities/cities.component";

const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'country', component: CountryComponent},
  {path: 'cities/:countryUuid', component: CitiesComponent},
  {path: 'city/:uuid', component: CityComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
