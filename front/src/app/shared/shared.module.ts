import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FlexLayoutModule } from '@angular/flex-layout';

import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { SpinnerComponent } from "./spinner/spinner.component";
import { MenuItems } from "./menu-items/menu-items";


@NgModule({
  imports: [
    CommonModule,
    FlexLayoutModule,
    FontAwesomeModule
  ],
  declarations: [SpinnerComponent],
  providers: [MenuItems],
  exports:[SpinnerComponent, FlexLayoutModule, FontAwesomeModule]
})
export class SharedModule { }
