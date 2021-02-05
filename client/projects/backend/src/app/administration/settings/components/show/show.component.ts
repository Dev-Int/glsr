import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { first } from 'rxjs/operators';

import { Settings } from '../../../shared/models/settings.model';
import { SettingsService } from '../../services/settings.service';

@Component({
  templateUrl: './show.template.html',
})
export class ShowComponent implements OnInit, OnDestroy {
  public settings: Settings;
  private readonly subscription: Subscription = new Subscription();

  constructor(private service: SettingsService) { }

  ngOnInit(): void {
    this.subscription.add(
      this.service.getSettings()
        .pipe(first())
        .subscribe((settings: Settings) => this.settings = settings),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }

}
