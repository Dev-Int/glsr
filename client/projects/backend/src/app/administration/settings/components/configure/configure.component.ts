import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Settings } from '../../../shared/models/settings.model';
import { SettingsService } from '../../services/settings.service';

@Component({
  templateUrl: './configure.template.html',
})
export class ConfigureComponent implements OnInit, OnDestroy {
  public form: FormGroup;
  public settings: Settings;
  private readonly subscription: Subscription = new Subscription();

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: SettingsService,
  ) {}

  ngOnInit(): void {
    this.subscription.add(
      this.route.paramMap.subscribe((param: ParamMap) => {
        if (this.subscription) {
          this.subscription.unsubscribe();
        }
        const uuid = param.get('uuid');
        if (null !== uuid) {
          this.service.getSettings()
            .pipe(first())
            .subscribe((settings: Settings) => {
              this.settings = settings;
            });
        }
        this.initForm(this.settings);
      }),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

  submit(): void {
    if (this.settings) {
      this.subscription.add(this.service.editSettings(this.settings.uuid, this.form.value).subscribe());
    } else {
      this.subscription.add(this.service.addSettings(this.form.value).subscribe());
    }
    this.router.navigate(['administration', 'settings']).then();
  }

  private initForm(settings: Settings = {locale: 'fr', currency: 'euro'}): void {
    this.form = this.fb.group({
      locale: [settings.locale, Validators.required],
      currency: [settings.currency, Validators.required],
    });
  }
}
