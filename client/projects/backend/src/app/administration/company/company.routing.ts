import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CompanyFormComponent } from './components/form/company-form.component';
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
    component: CompanyFormComponent,
  },
  {
    path: ':uuid/edit',
    data: {title: 'Éditer l\'établissement'},
    component: CompanyFormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CompanyRouting { }
