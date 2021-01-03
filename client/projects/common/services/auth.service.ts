import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Credentials } from '../model/credentials.model';
import { User } from '../model/user.model';

import { SessionService } from './session.service';

@Injectable({providedIn: 'root'})
export class AuthService {
    private currentUserSubject: BehaviorSubject<User>;
    currentUser: Observable<User>;

    constructor(
        private http: HttpClient,
        private session: SessionService,
    ) {
        this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('token')));
        this.currentUser = this.currentUserSubject.asObservable();
    }

    get currentUserValue(): User {
        return this.currentUserSubject.value;
    }

    login(user: Credentials): Observable<any> {
        return this.http.post('/api/login_check', {
            username: user.username,
            password: user.password,
        })
            .pipe(tap(response => this.session.setCookie({...response})));
    }

    redirectToApp(): void {
        if (this.session.isValid()) {
            const user = this.session.getUser();
            let redirectTo = localStorage.getItem('redirectTo');
            localStorage.removeItem('redirectTo');

            console.log(user.profile.roles);
            if (user.profile.roles.includes('ROLE_ADMIN')) {
                if (redirectTo && !redirectTo.startsWith('/backend')) {
                    redirectTo = null;
                }
                window.location.href = redirectTo || '/backend';
            }
        }
    }
}
