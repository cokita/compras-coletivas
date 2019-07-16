import { TestBed } from '@angular/core/testing';

import { ConstantsGlobalService } from './constants-global.service';

describe('ConstantsGlobalService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ConstantsGlobalService = TestBed.get(ConstantsGlobalService);
    expect(service).toBeTruthy();
  });
});
