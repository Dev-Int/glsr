import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { NgSelectModule } from '@ng-select/ng-select';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';
import { FamilyLogRouting } from './family-log.routing';


@NgModule({
  declarations: [ListComponent, FormComponent],
    imports: [
        CommonModule,
        FamilyLogRouting,
        ReactiveFormsModule,
        NgSelectModule,
    ],
})
export class FamilyLogModule {}
