import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { CKEditorModule } from "@ckeditor/ckeditor5-angular";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { CountryComponent } from './components/country/country.component';
import { HomeComponent } from './components/home/home.component';
import { MainNavComponent } from './components/common/main-nav/main-nav.component';
import {HttpClientModule} from "@angular/common/http";
import { CitiesComponent } from './components/cities/cities.component';
import { CityCreateComponent } from './components/cities/city-create/city-create.component';
import { SideBarComponent } from './components/side-bar/side-bar.component';
import { CountryCreateComponent } from './components/country/country-create/country-create.component';
import { CountryUpdateComponent } from './components/country/country-update/country-update.component';
import { CountryFormComponent } from './components/country/country-form/country-form.component';
import { FormsModule } from "@angular/forms";
import { CityUpdateComponent } from './components/cities/city-update/city-update.component';
import { CityFormComponent } from './components/cities/city-form/city-form.component';

@NgModule({
  declarations: [
    AppComponent,
    CountryComponent,
    HomeComponent,
    MainNavComponent,
    CitiesComponent,
    CityCreateComponent,
    SideBarComponent,
    CountryCreateComponent,
    CountryUpdateComponent,
    CountryFormComponent,
    CityUpdateComponent,
    CityFormComponent
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
