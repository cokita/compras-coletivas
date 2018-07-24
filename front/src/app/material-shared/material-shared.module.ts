import { NgModule } from '@angular/core';
import {MatButtonModule, 
  MatCheckboxModule, 
  MatCardModule, 
  MatFormFieldModule, 
  MatProgressSpinnerModule,
  MatCommonModule,
  MatInputModule
} from '@angular/material';

@NgModule({
  imports: [
    MatButtonModule, 
    MatCheckboxModule,
    MatCardModule,
    MatFormFieldModule,
    MatProgressSpinnerModule,
    MatCommonModule,
    MatInputModule
  ],
  exports: [
    MatButtonModule, 
    MatCheckboxModule,
    MatCardModule,
    MatFormFieldModule,
    MatProgressSpinnerModule,
    MatCommonModule,
    MatInputModule
  ],
  declarations: []
})

export class MaterialSharedModule { }
