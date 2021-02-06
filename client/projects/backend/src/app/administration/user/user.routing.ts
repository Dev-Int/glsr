import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';

const routes: Routes = [
  {
    path: '',
    data: {title: 'Utilisateurs'},
    component: ListComponent,
  },
  {
    path: 'new',
    data: {title: 'Nouvel utilisateur'},
    component: FormComponent,
  },
  {
    path: ':uuid/edit',
    data: {title: 'Modifier utilisateur'},
    component: FormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class UserRouting { }
