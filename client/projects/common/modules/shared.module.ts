import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { FooterModule } from './footer/footer.module';
import { HeaderModule } from './header/header.module';
import { PanelModule } from './panel/panel.module';
import { PipeModule } from './pipe/pipe.module';

@NgModule({
  declarations: [],
  imports: [
    FooterModule,
    HeaderModule,
    PanelModule,
    PipeModule,
    CommonModule,
  ],
  exports: [
    FooterModule,
    HeaderModule,
    PanelModule,
    PipeModule,
    CommonModule,
  ],
})
export class SharedModule {}
