import {QuestEntity} from "../../quest-entity";

export class QuestResponse {
  public status: string = '';
  public quest: QuestEntity = new QuestEntity();
}
