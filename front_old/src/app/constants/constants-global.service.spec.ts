import { TestBed, inject } from '@angular/core/testing';

import { ConstantsGlobalService } from './constants-global.service';

describe('ConstantsGlobalService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ConstantsGlobalService]
    });
  });

  it('should be created', inject([ConstantsGlobalService], (service: ConstantsGlobalService) => {
    expect(service).toBeTruthy();
  }));
});
