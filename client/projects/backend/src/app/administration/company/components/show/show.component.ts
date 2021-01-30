import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './show.template.html',
  styleUrls: ['./show.styles.scss'],
})
export class ShowComponent implements OnInit {
  companies$: Observable<Array<Company>> = this.service.companies$;

  constructor(private service: CompanyService) {}

  ngOnInit(): void {
    this.service.getCompanies()
      .pipe(tap())
      .subscribe();
  }

  delete(uuid: string): void {
    this.service.deleteCompany(uuid);
  }
}
