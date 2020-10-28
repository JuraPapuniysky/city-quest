import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { CKEditorModule } from "@ckeditor/ckeditor5-angular";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { CountryComponent } from './components/country/country.component';
import { HomeComponent } from './components/home/home.component';
import { MainNavComponent } from './components/common/main-nav/main-nav.component';
import {HttpClientModule} from "@angular/common/http";
import { CityComponent } from "./components/cities/city/city.component";
import { CitiesComponent } from './components/cities/cities.component';
import { CreateCityComponent } from './components/cities/create-city/create-city.component';
import { SideBarComponent } from './components/side-bar/side-bar.component';
import { CountryCreateComponent } from './components/country/country-create/country-create.component';
import { CountryUpdateComponent } from './components/country/country-update/country-update.component';
import { CountryFormComponent } from './components/country/country-form/country-form.component';
import { FormsModule } from "@angular/forms";

@NgModule({
  declarations: [
    AppComponent,
    CountryComponent,
    HomeComponent,
    MainNavComponent,
    CityComponent,
    CitiesComponent,
    CreateCityComponent,
    SideBarComponent,
    CountryCreateComponent,
    CountryUpdateComponent,
    CountryFormComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    CKEditorModule,
    FormsModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
