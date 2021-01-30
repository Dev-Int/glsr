import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

import { Company } from '../../shared/models/company.model';

@Injectable({providedIn: 'root'})
export class CompanyService {
  companies$: BehaviorSubject<Array<Company>> = new BehaviorSubject([]);

  getCompanies(): Array<Company> {
    return this.companies$.value;
  }

  getCompany(index: number): Company {
    return this.companies$.value[index];
  }

  addCompany(data: Company): void {
    const value = this.companies$.value;
    this.companies$.next([...value, data]);
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

  constructor() {}
}
