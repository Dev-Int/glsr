import { registerLocaleData } from '@angular/common';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import localeFr from '@angular/common/locales/fr';
import { DEFAULT_CURRENCY_CODE, LOCALE_ID, NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';

import { environment } from '../../../common/environment/environment';
import { ENVIRONMENT } from '../../../common/environment/environment.config';
import { FooterModule } from '../../../common/modules/footer/footer.module';
import { HeaderModule } from '../../../common/modules/header/header.module';
import { PipeModule } from '../../../common/modules/pipe/pipe.module';
import { ReqInterceptor } from '../../../common/req.interceptor';

import { AppComponent } from './app.component';
import { AppRouting } from './app.routing';

registerLocaleData(localeFr, 'fr');

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    ReactiveFormsModule,

    PipeModule,
    AppRouting,
    HeaderModule,
    FooterModule,
  ],
  providers: [
    {provide: HTTP_INTERCEPTORS, useClass: ReqInterceptor, multi: true},
    {provide: LOCALE_ID, useValue: 'fr-FR'},
    {provide: DEFAULT_CURRENCY_CODE, useValue: 'EUR'},
    {provide: ENVIRONMENT, useValue: environment},
  ],
  bootstrap: [AppComponent],
})
export class AppModule { }
