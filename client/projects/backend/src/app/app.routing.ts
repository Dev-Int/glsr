import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AuthGuard } from '../../../common/services/auth/auth.guard';

const routes: Routes = [
  {
    path: 'administration',
    canActivate: [AuthGuard],
    data: {title: 'Administration'},
    loadChildren: () => import('./administration/administration.module').then(m => m.AdministrationModule),
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: [AuthGuard],
})
export class AppRouting {}
