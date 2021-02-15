import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, map, tap } from 'rxjs/operators';

import { FamilyLog } from '../../../../../../common/model/family-log.model';

@Injectable({providedIn: 'root'})
export class FamilyLogService {
  public familyLogs$: BehaviorSubject<Array<FamilyLog>> = new BehaviorSubject(null);

  constructor(private http: HttpClient) {}

  getFamilyLogs(): Observable<Array<FamilyLog>> {
    return this.http.get<Array<FamilyLog>>('/api/administration/family-logs')
      .pipe(
        filter((familyLogs: Array<FamilyLog>) => familyLogs !== null),
        tap((familyLogs: Array<FamilyLog>) => {
          this.familyLogs$.next(familyLogs);
        }),
      );
  }

  getFamilyLog(uuid: string): Observable<FamilyLog> {
    return this.familyLogs$.pipe(
      filter((familyLogs: Array<FamilyLog>) => familyLogs !== null),
      map((familyLogs: Array<FamilyLog>) => {
        return familyLogs[familyLogs.findIndex((familyLog: FamilyLog) => familyLog.uuid === uuid)];
      }),
    );
  }

  addFamilyLog(data: FamilyLog): Observable<FamilyLog> {
    return this.http.post<FamilyLog>('/api/administration/family-logs/', data).pipe(
      tap((familyLogAdded: FamilyLog) => {
        const value = this.familyLogs$.value;
        this.familyLogs$.next([...value, familyLogAdded]);
      }),
    );
  }
}
