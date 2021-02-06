import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { PipeModule } from '../../../../../common/modules/pipe/pipe.module';

import { CompanyRouting } from './company.routing';
import { FormComponent } from './components/form/form.component';
import { ShowComponent } from './components/show/show.component';

@NgModule({
  declarations: [
    FormComponent,
    ShowComponent,
  ],
  imports: [
    CommonModule,
    CompanyRouting,
    PipeModule,
    ReactiveFormsModule,
  ],
})
export class CompanyModule {}
