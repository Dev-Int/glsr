import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, map, tap } from 'rxjs/operators';

import { Profile } from '../../../../../../common/model/profile.model';

@Injectable({providedIn: 'root'})
export class UserService {
  public users$: BehaviorSubject<Array<Profile>> = new BehaviorSubject(null);

  constructor(private http: HttpClient) {}

  getUsers(): Observable<Array<Profile>> {
    return this.http.get<Array<Profile>>('/api/administration/users')
      .pipe(
        filter((users: Array<Profile>) => users !== null),
        tap((users: Array<Profile>) => {
          this.users$.next(users);
        }),
      );
  }

  getUser(uuid: string): Observable<Profile> {
    return this.users$.pipe(
      filter((users: Array<Profile>) => users !== null),
      map((users: Array<Profile>) => {
        return users[users.findIndex((user: Profile) => user.uuid === uuid)];
      }),
    );
  }

  addUser(data: Profile): Observable<Profile> {
    return this.http.post<Profile>('/api/administration/users/', data).pipe(
      tap((userAdded: Profile) => {
        const value = this.users$.value;
        this.users$.next([...value, userAdded]);
      }),
    );
  }

  editUser(uuid: string, data: Profile): Observable<Profile> {
    return this.http.put<Profile>(`/api/administration/users/${uuid}`, data).pipe(
      tap((userUpdated: Profile) => {
        const value = this.users$.value;
        this.users$.next(value.map((user: Profile) => {
          if (user.uuid === userUpdated.uuid) {
            return userUpdated;
          } else {
            return user;
          }
        }));
      }),
    );
  }

  deleteUser(uuid: string): void {
    this.http.delete(`/api/administration/users/${uuid}`)
      .subscribe(() => {
        const users = this.users$.value;
        this.users$.next(users.filter((user: Profile) => user.uuid !== uuid));
      });
  }
}
