import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {QuestResponse} from "../../entities/Response/quest/quest-response";
import {environment} from "../../../environments/environment";
import {CountryEntity} from "../../entities/country-entity";
import {QuestsResponse} from "../../entities/Response/quest/quests-response";

@Injectable({
  providedIn: 'root'
})
export class QuestServiceService {
  private apiUrl: string = environment.apiUrl;
  private _questsResponse: QuestsResponse = new QuestsResponse();
  private _questResponse: QuestResponse = new QuestResponse();

  constructor(private httpClient: HttpClient) {
  }

  async getQuests(country: CountryEntity) {
    return new Promise((resolve, reject) => {
      this.httpClient.get(`${this.apiUrl}/quests/${country.uuid}`).toPromise()
        .then((data: QuestsResponse) => {
            this._questsResponse = data;
            resolve();
          }, error => reject(error));
    })
  }

  async getQuest(uuid: string) {
    return new Promise((resolve, reject) => {
      this.httpClient.get(`${this.apiUrl}/quest/${uuid}`).toPromise()
        .then((data: QuestResponse) => {
          this._questResponse = data;
          resolve();
        }, error => reject(error));
    });
  }

  get questsResponse(): QuestsResponse {
    return this._questsResponse;
  }

  get questResponse(): QuestResponse {
    return this._questResponse;
  }
}
