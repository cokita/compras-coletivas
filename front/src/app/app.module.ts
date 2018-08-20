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
import { HttpClientModule, HTTP_INTERCEPTORS } from "@angular/common/http";
import { FlexLayoutModule } from '@angular/flex-layout';
import { ErrorInterceptor } from './helpers/error-interceptor';

import { UserModule } from "./user/user.module";

import { AppRoutingModule } from './/app-routing.module';
import { AppComponent } from './app.component';
import { MaskDirective } from './mask/mask.directive';
import { HomeComponent } from './home/home.component';
import { UserGuard } from './user/user.guard';
import { LoginService } from './user/login/login.service';

library.add(faCoffee, fas, far);

@NgModule({
    declarations: [
        AppComponent,
        MaskDirective,
        HomeComponent
    ],
    imports: [
        BrowserModule,
        ReactiveFormsModule,
        FormsModule,
        AppRoutingModule,
        FontAwesomeModule,
        BrowserAnimationsModule,
        FlexLayoutModule,
        MaterialSharedModule,
        HttpClientModule,
        UserModule
    ],
    providers: [ UserGuard, LoginService,
        { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },],
    bootstrap: [AppComponent]
})
export class AppModule { }
