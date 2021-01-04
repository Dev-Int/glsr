import { NgModule } from '@angular/core';

import { AdministrationComponent } from './administration.component';
import { AdministrationRouting } from './administration.routing';

@NgModule({
  declarations: [AdministrationComponent],
  imports: [
    AdministrationRouting,
  ],
})
export class AdministrationModule {}
