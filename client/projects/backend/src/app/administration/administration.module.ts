import { NgModule } from '@angular/core';

import { AdministrationComponent } from './administration.component';
import { AdministrationRouting } from './administration.routing';
import { CompanyModule } from './company/company.module';

@NgModule({
  declarations: [
    AdministrationComponent,
  ],
  imports: [
    AdministrationRouting,
    CompanyModule,
  ],
})
export class AdministrationModule {}
