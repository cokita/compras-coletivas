import { MaterialSharedModuleModule } from './material-shared-module.module';

describe('MaterialSharedModuleModule', () => {
  let materialSharedModuleModule: MaterialSharedModuleModule;

  beforeEach(() => {
    materialSharedModuleModule = new MaterialSharedModuleModule();
  });

  it('should create an instance', () => {
    expect(materialSharedModuleModule).toBeTruthy();
  });
});
