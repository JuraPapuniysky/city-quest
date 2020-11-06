import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {CountryEntity} from "../../../entities/country-entity";
import {CityEntity} from "../../../entities/city-entity";
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';

@Component({
  selector: 'app-city-form',
  templateUrl: './city-form.component.html',
  styleUrls: ['./city-form.component.css']
})
export class CityFormComponent implements OnInit {

  public editor = ClassicEditor;

  @Input() country: CountryEntity;
  @Input() city: CityEntity;
  @Output() cityEvent: EventEmitter<CityEntity> = new EventEmitter<CityEntity>()

  constructor() { }

  ngOnInit(): void {
  }

  onSubmit() {
    this.cityEvent.emit(this.city);
  }
}
