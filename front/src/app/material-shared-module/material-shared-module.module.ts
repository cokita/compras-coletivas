import { NgModule } from '@angular/core';
import {MatButtonModule, MatCheckboxModule, MatCard, MatFormField} from '@angular/material';

@NgModule({
    imports: [MatButtonModule, MatCheckboxModule, MatCard, MatFormField],
    exports: [MatButtonModule, MatCheckboxModule, MatCard, MatFormField],
})
export class MaterialSharedModuleModule { }
