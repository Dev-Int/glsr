import {
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

import { SessionService } from './session.service';

@Injectable()
export class ReqInterceptor implements HttpInterceptor {

  constructor(private token: SessionService) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    const reqClone = request.clone({
      headers: request.headers
        .set('ContentType', 'application/json')
        .set('Authorization', 'Bearer ' + this.token.getToken()),
      responseType: 'json',
    });
    return next.handle(reqClone);
  }
}
