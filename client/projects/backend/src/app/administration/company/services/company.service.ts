import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

import { Company } from '../../shared/models/company.model';

@Injectable({providedIn: 'root'})
export class CompanyService {
  companies$: BehaviorSubject<Array<Company>> = new BehaviorSubject([]);

  getCompanies(): Observable<Array<Company>> {
    return this.http.get<Array<Company>>('/api/administration/companies/');
  }

  getCompany(uuid: string): Observable<Company> {
    return this.http.get<Company>( `/api/administration/companies/${uuid}`);
  }

  addCompany(data: Company): void {
    this.http.post<Company>('/api/administration/companies/', data)
      .subscribe((company: Company) => {
        const value = this.companies$.value;
        this.companies$.next([...value, company]);
      });
  }

  editCompany(data: Company): void {
    const value = this.companies$.value;
    this.companies$.next(value.map((company: Company) => {
      if (company.name === data.name) {
        return data;
      } else {
        return company;
      }
    }));
  }

  constructor(private http: HttpClient) {}
}
