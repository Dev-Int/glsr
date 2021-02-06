import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Settings } from '../../shared/models/settings.model';

@Injectable({providedIn: 'root'})
export class SettingsService {
  public settings$: BehaviorSubject<Settings> = new BehaviorSubject(null);

  constructor(private http: HttpClient) { }

  getSettings(): Observable<Settings> {
    return this.http.get<Settings>('/api/administration/settings')
      .pipe(tap((settings: Settings) => this.settings$.next(settings)));
  }

  addSettings(data: Settings): Observable<Settings> {
    return this.http.post('/api/administration/settings', data).pipe(
      tap((settings: Settings) => {
        this.settings$.next(settings);
      }),
    );
  }

  editSettings(uuid: string, data: Settings): Observable<Settings> {
    return this.http.put(`/api/administration/settings/${uuid}`, data).pipe(
      tap((settings: Settings) => {
        this.settings$.next(settings);
      }),
    );
  }
}
