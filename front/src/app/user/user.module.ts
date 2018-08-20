import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule ,ReactiveFormsModule } from '@angular/forms';
import { MaterialSharedModule } from '../material-shared/material-shared.module';
import { FlexLayoutModule } from '@angular/flex-layout';

import { RegisterComponent } from './register/register.component';
import { LoginComponent } from './login/login.component';
import { UserComponent } from './user.component';
import { LoginService } from './login/login.service';


@NgModule({
  imports: [
    CommonModule,MaterialSharedModule,FormsModule ,ReactiveFormsModule,FlexLayoutModule
  ],
  declarations: [LoginComponent,UserComponent, RegisterComponent],
  providers: [ LoginService]
})
export class UserModule { }
