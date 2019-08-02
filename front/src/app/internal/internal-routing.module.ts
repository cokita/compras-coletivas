//import { AdminLayoutComponent } from './admin-layout/admin-layout.component';
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {LayoutComponent} from "./layout/layout.component";
import {HomeComponent} from "./home/home.component";
import {UserGuard} from "./user.guard";
import {GroupsComponent} from "./groups/groups.component";
import {GroupsDetailsComponent} from "./groups/groups-details/groups-details.component";
import {GroupsSettingsComponent} from "./groups/groups-settings/groups-settings.component";
import {GroupsCreateComponent} from "./groups/groups-create/groups-create.component";

const routes: Routes = [
  {
    path: '',
    component: LayoutComponent,
    children: [
        { path: '', redirectTo: 'home', pathMatch: 'full' },
        { path: 'home', component: HomeComponent },
        { path: 'groups', component: GroupsComponent },
        { path: 'group-detail/:id', component: GroupsDetailsComponent },
        { path: 'group-settings', component: GroupsSettingsComponent },
        { path: 'group-create', component: GroupsCreateComponent},
    ],
    canActivate: [UserGuard],
  },
  { path: '**', redirectTo: '/admin/home' }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class InternalRoutingModule { }
