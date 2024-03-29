import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './shared/shared.module';
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {ErrorInterceptor} from "./helpers/error-interceptor";
import {HttpRequestInterceptor} from "./helpers/http-request-interceptor";

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserAnimationsModule,
    SharedModule,
    AppRoutingModule
  ],
    providers: [
        { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
        { provide: HTTP_INTERCEPTORS, useClass: HttpRequestInterceptor, multi: true }
    ],
  bootstrap: [AppComponent]
})
export class AppModule { }
