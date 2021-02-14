import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, tap } from 'rxjs/operators';

import { FamilyLog } from '../../../../../../common/model/family-log.model';

@Injectable({providedIn: 'root'})
export class FamilyLogService {
  public familyLogs$: BehaviorSubject<Array<FamilyLog>> = new BehaviorSubject(null);

  constructor(private http: HttpClient) {}

  getFamilyLogs(): Observable<Array<FamilyLog>> {
    return this.http.get<Array<FamilyLog>>('/api/administration/familylogs')
      .pipe(
        filter((familyLogs: Array<FamilyLog>) => familyLogs !== null),
        tap((familyLogs: Array<FamilyLog>) => {
          this.familyLogs$.next(familyLogs);
        }),
      );
  }
}
