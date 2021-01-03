import { InjectionToken } from '@angular/core';

import { Environment } from './environment.model';

export const ENVIRONMENT = new InjectionToken<Environment>('app.environment');
