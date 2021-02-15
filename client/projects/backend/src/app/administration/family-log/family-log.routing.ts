import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';

const routes: Routes = [
  {
    path: '',
    data: {title: 'Familles logistiques'},
    component: ListComponent,
  },
  {
    path: 'new',
    data: {title: 'Nouvelle famille'},
    component: FormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FamilyLogRouting {}
