import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { ListComponent } from './components/list/list.component';
import { SupplierRouting } from './supplier.routing';

@NgModule({
  declarations: [ListComponent],
  imports: [
    CommonModule,
    SupplierRouting,
  ],
})
export class SupplierModule {}
