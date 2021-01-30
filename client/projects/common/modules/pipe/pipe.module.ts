import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { PhonePipe } from './phone.pipe';

@NgModule({
  declarations: [
    PhonePipe,
  ],
  imports: [
    CommonModule,
  ],
  exports: [
    PhonePipe,
  ],
})
export class PipeModule { }
