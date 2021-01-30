import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './show.template.html',
  styleUrls: ['./show.styles.scss'],
})
export class ShowComponent implements OnInit, OnDestroy {
  companies: Array<Company>;
  subscription: Subscription = new Subscription();

  constructor(private service: CompanyService) {}

  ngOnInit(): void {
    this.subscription.add(this.service.companies$.subscribe((companies: Array<Company>) => {
      this.companies = companies;
    }));
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

}
