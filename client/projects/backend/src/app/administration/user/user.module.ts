import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { ListComponent } from './components/list/list.component';
import { UserRouting } from './user.routing';

@NgModule({
  declarations: [ListComponent],
  imports: [
    CommonModule,
    UserRouting,
  ],
})
export class UserModule {}
