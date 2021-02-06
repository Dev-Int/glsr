import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { FormComponent } from './components/form/form.component';
import { ShowComponent } from './components/show/show.component';

const routes: Routes = [
  {
    path: '',
    data: {title: 'Établissement'},
    component: ShowComponent,
  },
  {
    path: 'new',
    data: {title: 'Nouvel établissement'},
    component: FormComponent,
  },
  {
    path: ':uuid/edit',
    data: {title: 'Éditer l\'établissement'},
    component: FormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CompanyRouting { }
