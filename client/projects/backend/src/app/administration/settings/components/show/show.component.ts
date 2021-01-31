import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';

import { Settings } from '../../../shared/models/settings.model';
import { SettingsService } from '../../services/settings.service';

@Component({
  templateUrl: './show.template.html',
})
export class ShowComponent implements OnInit {
  settings: Settings;

  constructor(private service: SettingsService) { }

  ngOnInit(): void {
    this.service.getSettings()
      .pipe(first())
      .subscribe((settings: Settings) => this.settings = settings);
  }

}
