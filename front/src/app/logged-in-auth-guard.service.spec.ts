import { TestBed } from '@angular/core/testing';

import { LoggedInAuthGuardService } from './logged-in-auth-guard.service';

describe('LoggedInAuthGuardService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: LoggedInAuthGuardService = TestBed.get(LoggedInAuthGuardService);
    expect(service).toBeTruthy();
  });
});
