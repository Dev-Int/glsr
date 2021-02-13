import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
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
    { label: 'Lundi', value: '1' },
    { label: 'Mardi', value: '2' },
    { label: 'Mercredi', value: '3' },
    { label: 'Jeudi', value: '4' },
    { label: 'Vendredi', value: '5' },
    { label: 'Samedi', value: '6' },
  ];
  private readonly subscription: Subscription = new Subscription();

  get formGroup(): {[p: string]: AbstractControl} {
    return this.form.controls;
  }
  get orderDaysFormArray(): FormArray {
    return this.form.controls.orderDays as FormArray;
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: SupplierService,
  ) {}

  orderDaysFormGroup(data: Array<any>): void {
    this.daysControl.forEach(control => {
      let newControl = false;
      data.forEach(datum => {
        if (datum === control.value) {
          newControl = true;
        }
      });
      this.orderDaysFormArray.push(this.fb.control(newControl));
    });
  }

  submit(): void {
    if (this.form.invalid) {
      return;
    }

    this.form.value.orderDays = this.form.value.orderDays
      .map((checked, iter) => checked ? this.daysControl[iter].value : null)
      .filter(value => value !== null);

    if (this.supplier) {
      this.subscription.add(this.service.editSupplier(this.supplier.uuid, this.form.value).subscribe());
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
    orderDays: [],
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
      orderDays: this.fb.array([], Validators.required),
    });

    this.orderDaysFormGroup(supplier.orderDays);
  }
}
