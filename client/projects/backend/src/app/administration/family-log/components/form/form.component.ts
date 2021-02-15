import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Observable, Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { FamilyLog } from '../../../../../../../common/model/family-log.model';
import { FamilyLogService } from '../../services/family-log.service';

@Component({
  templateUrl: './form.template.html',
  styleUrls: ['./form.styles.scss'],
})
export class FormComponent implements OnInit, OnDestroy {
  public form: FormGroup;
  public familyLog: FamilyLog;
  public familyLogs$: Observable<Array<FamilyLog>> = this.service.familyLogs$;
  private readonly subscription: Subscription = new Subscription();

  get formGroup(): {[p: string]: AbstractControl} {
    return this.form.controls;
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: FamilyLogService,
  ) {}

  submit(): void {
    if (this.form.invalid) {
      console.log('invalid');
      return;
    }

    this.subscription.add(this.service.addFamilyLog(this.form.value).subscribe());

    this.router.navigate(['administration', 'familylogs']).then();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.route.paramMap.subscribe((param: ParamMap) => {
        const uuid = param.get('uuid');
        if (null !== uuid) {
          this.service.getFamilyLog(uuid)
            .pipe(first())
            .subscribe((familyLog: FamilyLog) => {
              this.familyLog = familyLog;
            });
        }
        this.initForm(this.familyLog);
      }),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

  private initForm(familyLog: FamilyLog = {
    label: '',
    parent: '',
  }): void {
    this.form = this.fb.group({
      label: [familyLog.label, Validators.required],
      parent: familyLog.parent,
    });
  }
}
