import { TestBed } from '@angular/core/testing';

import { UserUpdaterService } from './user-updater.service';

describe('UserUpdaterService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: UserUpdaterService = TestBed.get(UserUpdaterService);
    expect(service).toBeTruthy();
  });
});
