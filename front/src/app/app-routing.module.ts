import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from "./user/login/login.component";
import { UserComponent } from "./user/user.component";
import { RegisterComponent } from "./user/register/register.component";
import { HomeComponent } from "./home/home.component";
import { UserGuard } from './user/user.guard';

const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'register', component: RegisterComponent },

    { path: '', component: HomeComponent, canActivate: [UserGuard] },
    { path: 'user', component: UserComponent, canActivate: [UserGuard] },

    { path: '**', redirectTo: '' }
];

@NgModule({
    exports: [ RouterModule ],
    imports: [ RouterModule.forRoot(routes) ]
})

export class AppRoutingModule {}


