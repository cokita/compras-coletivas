import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from "./user/login/login.component";
import { RegisterComponent } from "./user/register/register.component";
import { LayoutComponent } from "./layout/layout.component";
import { UserGuard } from './user/user.guard';
import { HomeComponent } from "./home/home.component";
import { GroupsComponent } from "./groups/groups.component";
import { GroupDetailComponent } from "./groups/group-detail/group-detail.component";
import { GroupSettingsComponent } from "./groups/group-settings/group-settings.component";

const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'register', component: RegisterComponent },
    {
        path: '',
        component: LayoutComponent,
        children: [
            { path: '', redirectTo: 'home', pathMatch: 'full' },
            { path: 'home', component: HomeComponent },
            { path: 'groups', component: GroupsComponent },
            { path: 'group-detail', component: GroupDetailComponent },
            { path: 'group-settings', component: GroupSettingsComponent },
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


