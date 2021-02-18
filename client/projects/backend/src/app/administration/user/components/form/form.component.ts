import { Component, OnDestroy, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { CheckPasswordValidator } from '../../../../../../../common/directives/check-password.validator';
import { Profile } from '../../../../../../../common/model/profile.model';
import { UserService } from '../../services/user.service';

@Component({
  templateUrl: './form.template.html',
})
export class FormComponent implements OnInit, OnDestroy {
  public form: FormGroup;
  public user: Profile;
  private readonly subscription: Subscription = new Subscription();

  get formGroup(): {[p: string]: AbstractControl} {
    return this.form.controls;
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: UserService,
  ) {}

  submit(): void {
    if (this.form.invalid) {
      return;
    }

    this.formGroup.password_confirm.disable();
    const roles = this.formGroup.roles.value;
    this.formGroup.roles.setValue([roles]);

    if (this.user) {
      // @Todo: the request does not send
      this.subscription.add(this.service.editUser(this.user.uuid, this.form.value).subscribe());
    } else {
      this.subscription.add(this.service.addUser(this.form.value).subscribe());
    }
    // @Todo: when redirect ListComponent.users$ does not update
    this.router.navigate(['administration', 'users']).then();
  }

  reset(): void {
    this.form.reset();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.route.paramMap.subscribe((param: ParamMap) => {
        const uuid = param.get('uuid');
        if (null !== uuid) {
          this.service.getUser(uuid)
            .pipe(first())
            .subscribe((user: Profile) => {
              this.user = user;
            });
        }
        this.initForm(this.user);
      }),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

  private initForm(user: Profile = {
    username: '',
    email: '',
    password: '',
    roles: [],
  }): void {
    this.form = this.fb.group({
      username: [user.username, Validators.required],
      email: [user.email, [
        Validators.required,
        Validators.email,
      ]],
      password: [user.password, [
        Validators.required,
        Validators.minLength(8),
      ]],
      password_confirm: ['', [
        Validators.required,
        Validators.minLength(8),
      ]],
      roles: [user.roles, Validators.required],
    }, {validator: CheckPasswordValidator });
  }
}
