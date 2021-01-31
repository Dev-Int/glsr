import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Profile } from '../../../../../../../common/model/profile.model';
import { UserService } from '../../services/user.service';

@Component({
  templateUrl: './list.template.html',
})
export class ListComponent implements OnInit {
  users$: Observable<Array<Profile>> = this.service.users$;

  constructor(private service: UserService) {}

  ngOnInit(): void {
    this.service.getUsers()
      .pipe(tap())
      .subscribe();
  }
}
