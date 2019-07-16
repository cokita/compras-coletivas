import { NgModule } from '@angular/core';

import { InternalRoutingModule } from './internal-routing.module';
import { SharedModule } from '../shared/shared.module';

@NgModule({
  declarations: [],
  imports: [
    InternalRoutingModule,
    SharedModule
  ]
})
export class InternalModule { }
