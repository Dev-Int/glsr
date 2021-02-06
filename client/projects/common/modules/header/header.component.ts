import { Component, OnInit } from '@angular/core';

import { User } from '../../model/user.model';
import { SessionService } from '../../services/session.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
})
export class HeaderComponent implements OnInit {
  public user: User;

  constructor(
      private session: SessionService,
  ) {}

  logout(): void {
      this.session.logout();
  }

  ngOnInit(): void {
      this.user = {...this.session.user};
  }
}
