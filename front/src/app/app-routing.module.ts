import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from "./user/login/login.component";
import { UserComponent } from "./user/user.component";
import { RegisterComponent } from "./user/register/register.component";
import { LayoutComponent } from "./layout/layout.component";
import { UserGuard } from './user/user.guard';
import {HomeComponent} from "./home/home.component";

const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'register', component: RegisterComponent },
    {
        path: '',
        component: LayoutComponent,
        children: [
            { path: '', redirectTo: 'home', pathMatch: 'full' },
            { path: 'home', component: HomeComponent },
        ],
        canActivate: [UserGuard]
    },



    { path: '**', redirectTo: '' }
];

@NgModule({
    exports: [ RouterModule ],
    imports: [ RouterModule.forRoot(routes) ]
})

export class AppRoutingModule {}


