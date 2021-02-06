import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AdministrationComponent } from './administration.component';

const routes: Routes = [
  {
    path: '',
    component: AdministrationComponent,
    children: [
      {
        path: 'companies',
        data: {title: 'Établissement'},
        loadChildren: () => import('./company/company.module').then(m => m.CompanyModule),
      },
      {
        path: 'settings',
        data: {title: 'Configuration'},
        loadChildren: () => import('./settings/settings.module').then(m => m.SettingsModule),
      },
      {
        path: 'users',
        data: {title: 'Utilisateurs'},
        loadChildren: () => import('./user/user.module').then(m => m.UserModule),
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdministrationRouting {}
