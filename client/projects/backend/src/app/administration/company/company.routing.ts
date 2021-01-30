import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CompanyFormComponent } from './components/form/company-form.component';
import { ShowComponent } from './components/show/show.component';

const routes: Routes = [
  {
    path: '',
    component: ShowComponent,
  },
  {
    path: 'new',
    component: CompanyFormComponent,
  },
  {
    path: ':uuid/edit',
    component: CompanyFormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CompanyRouting { }
