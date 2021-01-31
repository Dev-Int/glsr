import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, ParamMap, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Settings } from '../../../shared/models/settings.model';
import { SettingsService } from '../../services/settings.service';

@Component({
  templateUrl: './configure.template.html',
})
export class ConfigureComponent implements OnInit {
  form: FormGroup;
  settings: Settings;
  subscription: Subscription;

  ngOnInit(): void {
    this.route.paramMap.subscribe((param: ParamMap) => {
      if (this.subscription) {
        this.subscription.unsubscribe();
      }
      const uuid = param.get('uuid');
      if (null !== uuid) {
        this.subscription = this.service.getSettings()
          .pipe(first())
          .subscribe((settings: Settings) => {
            this.settings = settings;
          });
      }
      this.initForm(this.settings);
    });
  }

  private initForm(settings: Settings = {locale: 'fr', currency: 'euro'}): void {
    this.form = this.fb.group({
      locale: [settings.locale, Validators.required],
      currency: [settings.currency, Validators.required],
    });
  }

  submit(): void {
    console.log(this.settings);
    if (this.settings) {
      this.service.editSettings(this.settings.uuid, this.form.value).subscribe();
    } else {
      this.service.addSettings(this.form.value).subscribe();
    }
    this.router.navigate(['administration', 'settings']);
  }

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private service: SettingsService,
  ) {}
}
