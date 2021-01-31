import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, tap } from 'rxjs/operators';

import { Profile } from '../../../../../../common/model/profile.model';

@Injectable({providedIn: 'root'})
export class UserService {
  users$: BehaviorSubject<Array<Profile>> = new BehaviorSubject(null);

  getUsers(): Observable<Array<Profile>> {
    return this.http.get('/api/administration/users')
      .pipe(
        filter((users: Array<Profile>) => users !== null),
        tap((users: Array<Profile>) => {
          this.users$.next(users);
        }),
      );
  }

  constructor(private http: HttpClient) {}
}
