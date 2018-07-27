import { UserService } from './service/user.service';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from "./login/login.component";
import { UserComponent } from "./user/user.component";

const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'user', component: UserComponent }
    
];

@NgModule({
    exports: [ RouterModule ],
    imports: [ RouterModule.forRoot(routes) ]
})

export class AppRoutingModule {}


