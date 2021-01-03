import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { catchError, first } from 'rxjs/operators';

import { AuthService } from '../../../../../common/services/auth.service';

@Component({
  templateUrl: './login.template.html',
})
export class LoginComponent implements OnInit {
    loading = false;
    invalidCredentials = false;
    form: FormGroup;

    onSubmit(): void {
        if (this.form.invalid) {
            return;
        }

        this.loading = true;
        this.service.login({...this.form.value})
            .pipe(first())
            .pipe(catchError(() => {
                this.loading = false;
                this.invalidCredentials = true;

                return new Observable(undefined);
            }))
            .subscribe(() => this.service.redirectToApp());
    }

    ngOnInit(): void {
        this.form = this.fb.group({
            username: ['', Validators.required],
            password: ['', Validators.required],
        });
    }

    constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: AuthService,
    ) {
        if (this.service.currentUserValue) {
            this.router.navigateByUrl('/');
        }
    }
}
