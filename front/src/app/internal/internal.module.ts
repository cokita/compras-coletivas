import {NgModule} from '@angular/core';

import {InternalRoutingModule} from './internal-routing.module';
import {SharedModule} from '../shared/shared.module';
import {LayoutComponent} from './layout/layout.component';
import {HeaderComponent} from './layout/header/header.component';
import {SidebarComponent} from './layout/sidebar/sidebar.component';
import {HomeComponent} from './home/home.component';
import {MaterialSharedModule} from "../material-shared/material-shared.module";
import { GroupsComponent } from './groups/groups.component';
import { GroupsDetailsComponent } from './groups/groups-details/groups-details.component';
import { GroupsSettingsComponent } from './groups/groups-settings/groups-settings.component';
import { UserComponent } from './user/user.component';
import { GroupsCreateComponent } from './groups/groups-create/groups-create.component';

@NgModule({
    declarations: [LayoutComponent, HeaderComponent, SidebarComponent, HomeComponent, GroupsComponent, GroupsDetailsComponent, GroupsSettingsComponent, UserComponent, GroupsCreateComponent],
    imports: [
        InternalRoutingModule,
        MaterialSharedModule,
        SharedModule
    ]
})
export class InternalModule {
}
