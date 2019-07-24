import { NgModule } from '@angular/core';
import { MaterialSharedModule } from '../material-shared/material-shared.module';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { FlexLayoutModule } from '@angular/flex-layout';
import { CommonModule } from '@angular/common';
import { MaskDirective } from './mask.directive';
import { UserPipe } from './pipes/user.pipe';
import {NgxSpinnerModule} from "ngx-spinner";

@NgModule({
  declarations: [MaskDirective, UserPipe],
  imports: [
      NgxSpinnerModule
  ],
  exports: [
    MaskDirective,
    CommonModule,
    MaterialSharedModule,
    FontAwesomeModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    FlexLayoutModule,
    UserPipe,
    NgxSpinnerModule
  ]
})
export class SharedModule {
  constructor() {
    // Add an icon to the library for convenient access in other components
    library.add(fas, far);
  }
}
