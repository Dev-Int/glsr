import { Injectable } from '@angular/core';
import { CookieService } from 'ngx-cookie-service';

import { User } from '../model/user.model';

import { JwtHelper } from './jwt-helper.service';

@Injectable({providedIn: 'root'})
export class SessionService {
    user: User;

    constructor(
        private cookie: CookieService,
    ) {}

    setCookie(user: User): void {
        console.log('set cookie', user);
        this.cookie.set('user', JSON.stringify({profile: user.profile}), null, '/', null, null, 'Strict');
        this.cookie.set('JWT', user.token, null, '/', null, null, 'Strict');
    }

    getUser(): User {
        try {
            return JSON.parse(this.cookie.get('user'));
        } catch (e) {
            this.logout();
        }
    }

    getToken(): string {
        return this.cookie.get('JWT');
    }

    isValid(): boolean {
        return !JwtHelper.isExpired(this.getToken());
    }

    logout(): void {
        this.cookie.deleteAll('/');
        localStorage.removeItem('token');
        this.user = null;
        window.location.href = '/';
    }
}
