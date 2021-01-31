import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, map, tap } from 'rxjs/operators';

import { Company } from '../../shared/models/company.model';

@Injectable({providedIn: 'root'})
export class CompanyService {
  companies$: BehaviorSubject<Array<Company>> = new BehaviorSubject(null);

  getCompanies(): Observable<Array<Company>> {
    return this.http.get<Array<Company>>('/api/administration/companies')
      .pipe(
        filter((companies: Array<Company>) => companies !== null),
        tap((companies: Array<Company>) => {
        this.companies$.next(companies);
      }),
    );
  }

  getCompany(uuid: string): Observable<Company> {
    return this.companies$.pipe(
      filter((companies: Array<Company>) => companies !== null),
      map((companies: Array<Company>) => {
        return companies[companies.findIndex((company: Company) => company.uuid === uuid)];
      }),
    );
  }

  addCompany(data: Company): Observable<Company> {
    return this.http.post<Company>('/api/administration/companies/', data).pipe(
      tap((companyAdded: Company) => {
          const value = this.companies$.value;
          this.companies$.next([...value, companyAdded]);
      }),
    );
  }

  editCompany(uuid: string, data: Company): Observable<Company> {
    return this.http.put(`/api/administration/companies/${uuid}`, data).pipe(
      tap((companyUpdated: Company) => {
        const value = this.companies$.value;
        this.companies$.next(value.map((company: Company) => {
          if (company.uuid === companyUpdated.uuid) {
            return companyUpdated;
          } else {
            return company;
          }
        }));
      }),
    );
  }

  deleteCompany(uuid: string): void {
    this.http.delete(`/api/administration/companies/${uuid}`)
      .subscribe(() => {
        const companies = this.companies$.value;
        this.companies$.next(companies.filter((company: Company) => company.uuid !== uuid));
      })
    ;
  }

  constructor(private http: HttpClient) {}
}
