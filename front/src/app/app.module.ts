import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule ,ReactiveFormsModule } from '@angular/forms';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import { MaterialSharedModule } from './material-shared/material-shared.module';


import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { AppRoutingModule } from './/app-routing.module';
import { UserComponent } from './user/user.component';

library.add(faCoffee, fas, far);

@NgModule({
    declarations: [
        AppComponent,
        LoginComponent,
        UserComponent
    ],
    imports: [
        BrowserModule,
        ReactiveFormsModule,
        FormsModule,
        AppRoutingModule,
        FontAwesomeModule,
        BrowserAnimationsModule,
        MaterialSharedModule
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule { }
