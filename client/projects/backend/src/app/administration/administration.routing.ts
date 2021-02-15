import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AuthGuard } from '../../../../common/services/auth/auth.guard';

import { AdministrationComponent } from './administration.component';

const routes: Routes = [
  {
    path: '',
    component: AdministrationComponent,
    children: [
      {
        path: 'users',
        data: {title: 'Utilisateurs'},
        canActivate: [AuthGuard],
        loadChildren: () => import('./user/user.module').then(m => m.UserModule),
      },
      {
        path: 'companies',
        data: {title: 'Établissement'},
        canActivate: [AuthGuard],
        loadChildren: () => import('./company/company.module').then(m => m.CompanyModule),
      },
      {
        path: 'settings',
        data: {title: 'Configuration'},
        canActivate: [AuthGuard],
        loadChildren: () => import('./settings/settings.module').then(m => m.SettingsModule),
      },
      {
        path: 'suppliers',
        data: {title: 'Fournisseurs'},
        canActivate: [AuthGuard],
        loadChildren: () => import('./supplier/supplier.module').then(m => m.SupplierModule),
      },
      {
        path: 'family-logs',
        data: {title: 'Familles logistiques'},
        loadChildren: () => import('./family-log/family-log.module').then(m => m.FamilyLogModule),
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdministrationRouting {}
