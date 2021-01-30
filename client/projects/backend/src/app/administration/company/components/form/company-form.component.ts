import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';

import { Company } from '../../../shared/models/company.model';
import { CompanyService } from '../../services/company.service';

@Component({
  selector: 'app-create',
  templateUrl: './company-form.template.html',
  styleUrls: ['./company-form.styles.scss'],
})
export class CompanyFormComponent implements OnInit {
  form: FormGroup;
  company: Company;

  get name(): FormControl {
    return <FormControl> this.form.get('name');
  }
  get address(): FormControl {
    return <FormControl> this.form.get('address');
  }

  ngOnInit(): void {
    this.route.paramMap.subscribe((param: ParamMap) => {
      const index = param.get('index');
      if (null !== index) {
        this.company = this.service.getCompany(Number(index));
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
      this.service.editCompany(this.form.value);
    } else {
      this.service.addCompany(this.form.value);
    }
    this.router.navigate(['..'], { relativeTo: this.route });
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
