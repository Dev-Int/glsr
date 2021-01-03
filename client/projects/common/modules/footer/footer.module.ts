import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { FooterComponent } from './footer.component';



@NgModule({
    declarations: [FooterComponent],
    exports: [
        FooterComponent,
    ],
    imports: [
        CommonModule,
    ],
})
export class FooterModule { }
