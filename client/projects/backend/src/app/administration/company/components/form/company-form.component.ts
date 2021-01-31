import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './company-form.template.html',
  styleUrls: ['./company-form.styles.scss'],
})
export class CompanyFormComponent implements OnInit {
  form: FormGroup;
  company: Company;
  subscription: Subscription;

  get name(): FormControl {
    return <FormControl> this.form.get('name');
  }
  get address(): FormControl {
    return <FormControl> this.form.get('address');
  }

  ngOnInit(): void {
    this.route.paramMap.subscribe((param: ParamMap) => {
      if (this.subscription) {
        this.subscription.unsubscribe();
      }
      const uuid = param.get('uuid');
      if (null !== uuid) {
        this.subscription = this.service.getCompany(uuid)
          .pipe(first())
          .subscribe((company: Company) => {
            this.company = company;
          });
      }
      this.initForm(this.company);
    });
  }

  private initForm(company: Company = {
    name: '',
    address: '',
    zipCode: '',
    town: '',
    country: '',
    phone: '',
    facsimile: '',
    email: '',
    contact: '',
    cellphone: '',
  }): void {
    this.form = this.fb.group({
      name: [company.name, Validators.required],
      address: [company.address, Validators.required],
      zipCode: [company.zipCode, [
        Validators.maxLength(5),
        Validators.minLength(5),
        Validators.required,
      ]],
      town: [company.town, Validators.required],
      country: [company.country, Validators.required],
      phone: [company.phone, Validators.required],
      facsimile: [company.facsimile, Validators.required],
      email: [company.email, [Validators.email, Validators.required]],
      contact: [company.contact, Validators.required],
      cellphone: [company.cellphone, Validators.required],
    });
  }

  submit(): void {
    if (this.company) {
      this.service.editCompany(this.company.uuid, this.form.value).subscribe();
    } else {
      this.service.addCompany(this.form.value).subscribe();
    }
    this.router.navigate(['administration', 'companies']);
  }

  reset(): void {
    this.form.reset();
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: CompanyService,
  ) {}
}
