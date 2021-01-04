import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AdministrationComponent } from './administration.component';

const routes: Routes = [
    {
        path: '',
        component: AdministrationComponent,
        children: [
            {
                path: 'company',
            },
            {
                path: 'settings',
            },
            {
                path: 'user',
            },
        ],
    },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdministrationRouting {}
