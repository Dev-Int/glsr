import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { ListComponent } from './components/list/list.component';
import { FamilyLogRouting } from './family-log.routing';


@NgModule({
  declarations: [ListComponent],
  imports: [
    CommonModule,
    FamilyLogRouting,
  ],
})
export class FamilyLogModule {}
