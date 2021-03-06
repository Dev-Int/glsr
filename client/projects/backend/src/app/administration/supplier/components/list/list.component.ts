import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, Subscription } from 'rxjs';
import { tap } from 'rxjs/operators';

import { Supplier } from '../../../../../../../common/model/supplier.model';
import { SupplierService } from '../../services/supplier.service';

@Component({
  templateUrl: './list.template.html',
  styleUrls: ['./list.styles.scss'],
})
export class ListComponent implements OnInit, OnDestroy {
  public suppliers$: Observable<Array<Supplier>> = this.service.suppliers$;
  private readonly subscription: Subscription = new Subscription();

  constructor(private service: SupplierService, private router: Router) {}

  delete(uuid: string): void {
    this.subscription.add(
      this.service.deleteSupplier(uuid),
    );

    this.router.navigate(['administration', 'suppliers']).then();
  }

  ngOnInit(): void {
    this.subscription.add(
      this.service.getSuppliers()
        .pipe(tap())
        .subscribe(),
    );
  }

  ngOnDestroy(): void {
    this.subscription.unsubscribe();
  }
}
