import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { CountryComponent } from './components/country/country.component';
import { HomeComponent } from './components/home/home.component';
import { MainNavComponent } from './components/common/main-nav/main-nav.component';
import {CountryService} from "./services/country/country.service";
import {HttpClientModule} from "@angular/common/http";
import { CityComponent } from './components/city/city.component';
import { CitiesComponent } from './components/cities/cities.component';

@NgModule({
  declarations: [
    AppComponent,
    CountryComponent,
    HomeComponent,
    MainNavComponent,
    CityComponent,
    CitiesComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
