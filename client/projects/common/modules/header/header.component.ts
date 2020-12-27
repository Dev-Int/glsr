import { Component, OnInit } from '@angular/core';

import { User } from '../../model/user.model';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
})
export class HeaderComponent implements OnInit {
  // @Todo User, auth, session and routing management to implement
  user: User | undefined;

  constructor() { }

  ngOnInit(): void {
  }

}
