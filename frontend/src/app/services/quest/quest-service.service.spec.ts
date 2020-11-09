import { TestBed } from '@angular/core/testing';

import { QuestServiceService } from './quest-service.service';

describe('QuestServiceService', () => {
  let service: QuestServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(QuestServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
