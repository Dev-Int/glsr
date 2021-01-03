import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-panel',
  template: `<div class="bg-white p-3 rounded-lg shadow {{ class }}"><ng-content></ng-content></div>`,
})
export class PanelComponent {
  @Input() class = '';
}
