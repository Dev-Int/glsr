import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ConfigureComponent } from './components/configure/configure.component';
import { ShowComponent } from './components/show/show.component';

const routes: Routes = [
  {
    path: '',
    component: ShowComponent,
  },
  {
    path: ':uuid/edit',
    component: ConfigureComponent,
  },
  {
    path: 'new',
    component: ConfigureComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SettingsRouting { }
