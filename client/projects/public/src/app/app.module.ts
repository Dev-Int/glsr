import { HttpClientModule } from '@angular/common/http';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { CookieService } from 'ngx-cookie-service';

import { environment } from '../../../common/environment/environment';
import { ENVIRONMENT } from '../../../common/environment/environment.config';

import { AppComponent } from './app.component';
import { AppRouting } from './app.routing';
import { LoginComponent } from './components/login/login.component';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    ReactiveFormsModule,

    AppRouting,
  ],
  bootstrap: [AppComponent],
  providers: [
    {provide: ENVIRONMENT, useValue: environment},
    CookieService,
  ],
})
export class AppModule {}
