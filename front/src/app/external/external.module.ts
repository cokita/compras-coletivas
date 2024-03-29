import { NgModule } from '@angular/core';

import { ExternalRoutingModule } from './external-routing.module';
import { LoginComponent } from './login/login.component';
import { SiteLayoutComponent } from './site-layout/site-layout.component';
import { HomeComponent } from './home/home.component';
import { SharedModule } from '../shared/shared.module';
import { RegisterComponent } from './register/register.component';

@NgModule({
  declarations: [LoginComponent, SiteLayoutComponent, HomeComponent, RegisterComponent],
  imports: [
    ExternalRoutingModule,
    SharedModule
  ]
})
export class ExternalModule { }
