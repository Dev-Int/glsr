import {
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

import { SessionService } from './services/session.service';

@Injectable()
export class ReqInterceptor implements HttpInterceptor {

  constructor(private token: SessionService) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    const reqClone = request.clone({
      headers: request.headers.append(
        'Authorization', 'Bearer ' + this.token.getToken(),
      ),
    });
    return next.handle(reqClone);
  }
}
