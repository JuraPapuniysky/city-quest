import { Component, OnInit } from '@angular/core';
import {QuestEntity} from "../../entities/quest-entity";
import {ActivatedRoute} from "@angular/router";
import {CountryEntity} from "../../entities/country-entity";

@Component({
  selector: 'app-quests',
  templateUrl: './quests.component.html',
  styleUrls: ['./quests.component.css']
})
export class QuestsComponent implements OnInit {

  public quests: Array<QuestEntity> = [];

  constructor(private activatedRoute: ActivatedRoute) { }

  ngOnInit(): void {
    this.activatedRoute.params.subscribe(async params => {

    })
  }

}
