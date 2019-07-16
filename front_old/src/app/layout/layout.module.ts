import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SharedModule } from "../shared/shared.module";
import { HeaderComponent } from './header/header.component';
import { LayoutComponent } from './layout.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { MaterialSharedModule } from "../material-shared/material-shared.module";
import { RouterModule } from '@angular/router';


@NgModule({
  imports: [
    CommonModule,
    SharedModule,
    MaterialSharedModule,
    RouterModule
  ],
  declarations: [HeaderComponent, LayoutComponent, SidebarComponent]
})
export class LayoutModule { }
