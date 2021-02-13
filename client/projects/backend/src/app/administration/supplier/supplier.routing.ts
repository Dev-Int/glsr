import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';

const routes: Routes = [
  {
    path: '',
    data: {title: 'Fournisseurs'},
    component: ListComponent,
  },
  {
    path: 'new',
    data: {title: 'Nouveau fournisseur'},
    component: FormComponent,
  },
  {
    path: ':uuid/edit',
    data: {title: 'Modifier un fournisseur'},
    component: FormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SupplierRouting {}
