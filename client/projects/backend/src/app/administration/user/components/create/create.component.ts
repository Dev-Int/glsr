import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Profile } from '../../../../../../../common/model/profile.model';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.template.html',
})
export class CreateComponent implements OnInit {
  form: FormGroup;
  user: Profile;
  subscription: Subscription;
  password_confirm: FormControl;

  ngOnInit(): void {
    this.route.paramMap.subscribe((param: ParamMap) => {
      if (this.subscription) {
        this.subscription.unsubscribe();
      }
      const uuid = param.get('uuid');
      if (null !== uuid) {
        this.subscription = this.service.getUser(uuid)
          .pipe(first())
          .subscribe((user: Profile) => {
            this.user = user;
          });
      }
      this.initForm(this.user);
    });
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
      roles: [user.roles, Validators.required],
    });
  }

  submit(): void {
    // @todo: Add password verification
    this.service.addUser(this.form.value);
    this.router.navigate(['administration', 'users']);
  }

  reset(): void {
    this.form.reset();
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: UserService,
  ) {}
}
