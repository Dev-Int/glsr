import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';
import { UserRouting } from './user.routing';

@NgModule({
  declarations: [ListComponent, FormComponent],
  imports: [
    CommonModule,
    UserRouting,
    ReactiveFormsModule,
  ],
})
export class UserModule {}
