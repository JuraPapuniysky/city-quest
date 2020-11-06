import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {CountryEntity} from "../../../entities/country-entity";

@Component({
  selector: 'app-country-form',
  templateUrl: './country-form.component.html',
  styleUrls: ['./country-form.component.css']
})
export class CountryFormComponent implements OnInit {

  public editor = ClassicEditor;

  @Input() country: CountryEntity;
  @Output() updateCountryEvent: EventEmitter<CountryEntity> = new EventEmitter<CountryEntity>();

  constructor() { }

  ngOnInit(): void {
  }

  onSubmit(country: CountryEntity): void {
    this.updateCountryEvent.emit(country);
  }

}
