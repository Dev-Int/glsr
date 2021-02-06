import { ErrorHandler, Injectable } from '@angular/core';
import * as Sentry from '@sentry/angular';
import { Integrations } from '@sentry/tracing';

import { environment } from '../environment/environment';

@Injectable()
export class GlobalErrorHandler implements ErrorHandler {

  constructor() {
    if ('production' === environment.name) {
      Sentry.init({
        dsn: 'https://99d640a181134ce4b33a1a0585c149d1@o517701.ingest.sentry.io/5625851',
        integrations: [
          new Integrations.BrowserTracing({
            tracingOrigins: ['localhost', 'http://locahost/api'],
            routingInstrumentation: Sentry.routingInstrumentation,
          }),
        ],
        tracesSampleRate: 1.0,
      });
    }
  }

  handleError(error: any): void {
    if ('production' === environment.name) {
      Sentry.captureException(error.originalError || error);
    }
    console.error('Error from global error handler', error);
  }
}
