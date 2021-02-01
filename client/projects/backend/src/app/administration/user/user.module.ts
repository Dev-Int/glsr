import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { CreateComponent } from './components/create/create.component';
import { ListComponent } from './components/list/list.component';
import { UserRouting } from './user.routing';

@NgModule({
  declarations: [ListComponent, CreateComponent],
  imports: [
    CommonModule,
    UserRouting,
    ReactiveFormsModule,
  ],
})
export class UserModule {}
