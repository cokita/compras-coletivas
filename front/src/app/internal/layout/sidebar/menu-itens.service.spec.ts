import { TestBed } from '@angular/core/testing';

import { MenuItensService } from './menu-itens.service';

describe('MenuItensService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: MenuItensService = TestBed.get(MenuItensService);
    expect(service).toBeTruthy();
  });
});
