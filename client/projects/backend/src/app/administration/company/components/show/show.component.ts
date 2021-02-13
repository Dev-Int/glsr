import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, Subscription } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './show.template.html',
  styleUrls: ['./show.styles.scss'],
})
export class ShowComponent implements OnInit, OnDestroy {
  public companies$: Observable<Array<Company>> = this.service.companies$;
  private readonly subscription: Subscription = new Subscription();

  constructor(private service: CompanyService, private router: Router) {}

  delete(uuid: string): void {
    this.subscription.add(
      this.service.deleteCompany(uuid),
    );
    this.router.navigate(['administration', 'companies']).then();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.service.getCompanies()
        .pipe(tap())
        .subscribe(),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }
}
