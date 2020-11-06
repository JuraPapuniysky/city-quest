import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {CountryComponent} from "./components/country/country.component";
import {HomeComponent} from "./components/home/home.component";
import {CitiesComponent} from "./components/cities/cities.component";
import {CityCreateComponent} from "./components/cities/city-create/city-create.component";
import {CountryCreateComponent} from "./components/country/country-create/country-create.component";
import {CountryUpdateComponent} from "./components/country/country-update/country-update.component";
import {CityUpdateComponent} from "./components/cities/city-update/city-update.component";


const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'country', component: CountryComponent},
  {path: 'country/create', component: CountryCreateComponent},
  {path: 'country/update/:uuid', component: CountryUpdateComponent},
  {path: 'cities/:countryUuid', component: CitiesComponent},
  {path: 'city/create/:countryUuid', component: CityCreateComponent},
  {path: 'city/update/:uuid', component: CityUpdateComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
