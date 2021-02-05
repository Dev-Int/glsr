import { Component, OnDestroy, OnInit } from '@angular/core';
import { Observable, Subscription } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Profile } from '../../../../../../../common/model/profile.model';
import { UserService } from '../../services/user.service';

@Component({
  templateUrl: './list.template.html',
})
export class ListComponent implements OnInit, OnDestroy {
  public users$: Observable<Array<Profile>> = this.service.users$;
  private readonly subscription = new Subscription();

  constructor(private service: UserService) {}

  ngOnInit(): void {
    this.subscription.add(
      this.service.getUsers()
        .pipe(tap())
        .subscribe(),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }
}
