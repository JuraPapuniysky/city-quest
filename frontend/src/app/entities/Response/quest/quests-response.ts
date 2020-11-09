import {QuestEntity} from "../../quest-entity";

export class QuestsResponse {
  public status: string = '';
  public quests: Array<QuestEntity> = [];
}
