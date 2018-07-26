import { UserService } from './service/user.service';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule ,ReactiveFormsModule } from '@angular/forms';
import { FlexLayoutModule } from '@angular/flex-layout';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import { MaterialSharedModule } from './material-shared/material-shared.module';
import { HttpModule } from '@angular/http';

import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { AppRoutingModule } from './/app-routing.module';
import { UserComponent } from './user/user.component';
import { MaskDirective } from './mask/mask.directive';

library.add(faCoffee, fas, far);

@NgModule({
    declarations: [
        AppComponent,
        LoginComponent,
        UserComponent,
        MaskDirective
    ],
    imports: [
        BrowserModule,
        ReactiveFormsModule,
        FormsModule,
        AppRoutingModule,
        FontAwesomeModule,
        BrowserAnimationsModule,
        MaterialSharedModule,
        FlexLayoutModule,
        HttpModule
    ],
    providers: [ UserService ],
    bootstrap: [AppComponent]
})
export class AppModule { }
