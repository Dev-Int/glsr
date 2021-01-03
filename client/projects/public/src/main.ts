import { enableProdMode } from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';

import { environment } from '../../common/environment/environment';

import { AppModule } from './app/app.module';

if (environment.name === 'production') {
  enableProdMode();
}

const bootstrap = () => platformBrowserDynamic().bootstrapModule(AppModule);

bootstrap()
  .catch(err => console.error(err));
