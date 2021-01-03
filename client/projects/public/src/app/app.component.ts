import { Component } from '@angular/core';

@Component({
  selector: 'app-component',
  template: `
  <div class="container">
    <div class="row">
        <div class="col">
          <router-outlet></router-outlet>
        </div>
    </div>
  </div>
  `,
})
export class AppComponent {
  title = 'public';
}
