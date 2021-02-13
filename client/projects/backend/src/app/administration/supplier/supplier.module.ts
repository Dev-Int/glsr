import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { SharedModule } from '../../../../../common/modules/shared.module';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';
import { SupplierRouting } from './supplier.routing';

@NgModule({
  declarations: [ListComponent, FormComponent],
  imports: [
    CommonModule,
    SupplierRouting,
    SharedModule,
    ReactiveFormsModule,
  ],
})
export class SupplierModule {}
