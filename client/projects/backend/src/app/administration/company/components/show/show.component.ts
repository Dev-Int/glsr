import { Component, OnInit } from '@angular/core';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './show.template.html',
  styleUrls: ['./show.styles.scss'],
})
export class ShowComponent implements OnInit {
  companies: Array<Company>;

  constructor(private service: CompanyService) {}

  ngOnInit(): void {
    this.service.getCompanies().subscribe((companies: Array<Company>) => {
      this.companies = companies;
      console.log(this.companies);
    });
  }
}
