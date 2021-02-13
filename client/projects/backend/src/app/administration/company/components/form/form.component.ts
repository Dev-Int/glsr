import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  templateUrl: './form.template.html',
  styleUrls: ['./form.styles.scss'],
})
export class FormComponent implements OnInit, OnDestroy {
  public form: FormGroup;
  public company: Company;
  private readonly subscription: Subscription = new Subscription();

  get formGroup(): {[p: string]: AbstractControl} {
    return this.form.controls;
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: CompanyService,
  ) {}

  submit(): void {
    if (this.form.invalid) {
      return;
    }

    if (this.company) {
      this.subscription.add(this.service.editCompany(this.company.uuid, this.form.value).subscribe());
    } else {
      this.subscription.add(this.service.addCompany(this.form.value).subscribe());
    }

    this.router.navigate(['administration', 'companies']).then();
  }

  reset(): void {
    this.form.reset();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.route.paramMap.subscribe((param: ParamMap) => {
        const uuid = param.get('uuid');
        if (null !== uuid) {
          this.service.getCompany(uuid)
            .pipe(first())
            .subscribe((company: Company) => {
              this.company = company;
            });
        }
        this.initForm(this.company);
      }),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
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
}
