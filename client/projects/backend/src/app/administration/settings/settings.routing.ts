import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ConfigureComponent } from './components/configure/configure.component';
import { ShowComponent } from './components/show/show.component';

const routes: Routes = [
  {
    path: '',
    data: {title: 'Configuration'},
    component: ShowComponent,
  },
  {
    path: 'new',
    data: {title: 'Nouvelle configuration'},
    component: ConfigureComponent,
  },
  {
    path: ':uuid/edit',
    data: {title: 'Edit configuration'},
    component: ConfigureComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SettingsRouting { }
