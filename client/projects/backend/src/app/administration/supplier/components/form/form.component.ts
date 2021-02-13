import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Supplier } from '../../../../../../../common/model/supplier.model';
import { SupplierService } from '../../services/supplier.service';

@Component({
  templateUrl: './form.template.html',
  styleUrls: ['./form.styles.scss'],
})
export class FormComponent implements OnInit, OnDestroy {
  public form: FormGroup;
  public supplier: Supplier;
  public daysControl: Array<any> = [
    { label: 'Lundi', value: 1 },
    { label: 'Mardi', value: 2 },
    { label: 'Mercredi', value: 3 },
    { label: 'Jeudi', value: 4 },
    { label: 'Vendredi', value: 5 },
    { label: 'Samedi', value: 6 },
  ];
  private readonly subscription: Subscription = new Subscription();

  get formGroup(): {[p: string]: AbstractControl} {
    return this.form.controls;
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: SupplierService,
  ) {}

  onOrderDaysChange(event): void {
    const checkArray: FormArray = this.formGroup.orderDays as FormArray;
    let iter = 0;
    checkArray.controls.forEach((item: FormControl) => {
      if (null === item.value) {
        checkArray.removeAt(iter);
        return;
      }
      iter++;
    });

    if (event.target.checked) {
      checkArray.push(new FormControl(event.target.value));
    } else {
      let iter = 0;
      checkArray.controls.forEach((item: FormControl) => {
        if (item.value === event.target.value || null === item.value) {
          checkArray.removeAt(iter);
          return;
        }
        iter++;
      });
    }
  }

  submit(): void {
    if (this.form.invalid) {
      return;
    }
    if (this.supplier) {
      return;
    } else {
      this.subscription.add(this.service.addSupplier(this.form.value).subscribe());
    }

    this.router.navigate(['administration', 'suppliers']).then();
  }

  reset(): void {
    this.form.reset();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.route.paramMap.subscribe((param: ParamMap) => {
        const uuid = param.get('uuid');
        if (null !== uuid) {
          this.service.getSupplier(uuid)
            .pipe(first())
            .subscribe((supplier: Supplier) => {
              this.supplier = supplier;
            });
        }
        this.initForm(this.supplier);
      }),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

  private initForm(supplier: Supplier = {
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
    familyLog: '',
    delayDelivery: 0,
    orderDays: null,
  }): void {
    this.form = this.fb.group({
      name: [supplier.name, Validators.required],
      address: [supplier.address, Validators.required],
      zipCode: [supplier.zipCode, [
        Validators.maxLength(5),
        Validators.minLength(5),
        Validators.required,
      ]],
      town: [supplier.town, Validators.required],
      country: [supplier.country, Validators.required],
      phone: [supplier.phone, [
        Validators.required,
        Validators.minLength(10),
        Validators.maxLength(10),
      ]],
      facsimile: [supplier.facsimile, [
        Validators.required,
        Validators.minLength(10),
        Validators.maxLength(10),
      ]],
      email: [supplier.email, [Validators.email, Validators.required]],
      contact: [supplier.contact, Validators.required],
      cellphone: [supplier.cellphone, [
        Validators.required,
        Validators.minLength(10),
        Validators.maxLength(10),
      ]],
      familyLog: [supplier.familyLog, Validators.required],
      delayDelivery: [supplier.delayDelivery, Validators.required],
      orderDays: this.fb.array([supplier.orderDays], Validators.required),
    });
  }
}
