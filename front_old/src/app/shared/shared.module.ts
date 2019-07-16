import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FlexLayoutModule } from '@angular/flex-layout';

import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { SpinnerComponent } from "./spinner/spinner.component";
import { MenuItems } from "./menu-items/menu-items";

import {RouterModule} from "@angular/router";


@NgModule({
  imports: [
    CommonModule,
    FlexLayoutModule,
    FontAwesomeModule,
    RouterModule
  ],
  declarations: [SpinnerComponent],
  providers: [MenuItems],
  exports:[SpinnerComponent,
      FlexLayoutModule,
      FontAwesomeModule,
      RouterModule]
})
export class SharedModule { }
