import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { ConfigureComponent } from './components/configure/configure.component';
import { ShowComponent } from './components/show/show.component';
import { SettingsRouting } from './settings.routing';

@NgModule({
  declarations: [ShowComponent, ConfigureComponent],
  imports: [
    CommonModule,
    SettingsRouting,
    ReactiveFormsModule,
  ],
})
export class SettingsModule {}
