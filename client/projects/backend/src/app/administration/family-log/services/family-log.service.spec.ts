import { TestBed } from '@angular/core/testing';

import { FamilyLogService } from './family-log.service';

describe('FamilyLogService', () => {
  let service: FamilyLogService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(FamilyLogService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
