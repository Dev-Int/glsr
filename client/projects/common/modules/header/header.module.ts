import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';

import { HeaderComponent } from './header.component';

@NgModule({
  declarations: [HeaderComponent],
  exports: [
    HeaderComponent,
  ],
    imports: [
        CommonModule,
        RouterModule,
    ],
})
export class HeaderModule { }
