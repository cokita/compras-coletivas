import { NgModule } from '@angular/core';
import {MatButtonModule, 
  MatCheckboxModule, 
  MatCardModule, 
  MatFormFieldModule, 
  MatProgressSpinnerModule,
  MatCommonModule,
  MatInputModule,
  MatSnackBarModule
} from '@angular/material';

@NgModule({
  imports: [
    MatButtonModule, 
    MatCheckboxModule,
    MatCardModule,
    MatFormFieldModule,
    MatProgressSpinnerModule,
    MatCommonModule,
    MatInputModule,
    MatSnackBarModule
  ],
  exports: [
    MatButtonModule, 
    MatCheckboxModule,
    MatCardModule,
    MatFormFieldModule,
    MatProgressSpinnerModule,
    MatCommonModule,
    MatInputModule,
    MatSnackBarModule
  ],
  declarations: []
})

export class MaterialSharedModule { }
