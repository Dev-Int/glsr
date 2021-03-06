import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { filter, map, tap } from 'rxjs/operators';

import { Supplier } from '../../../../../../common/model/supplier.model';

@Injectable({providedIn: 'root'})
export class SupplierService {
  public suppliers$: BehaviorSubject<Array<Supplier>> = new BehaviorSubject(null);

  constructor(private http: HttpClient) {}

  getSuppliers(): Observable<Array<Supplier>> {
    return this.http.get<Array<Supplier>>('/api/administration/suppliers')
      .pipe(
        filter((suppliers: Array<Supplier>) => suppliers !== null),
        tap((suppliers: Array<Supplier>) => {
          this.suppliers$.next(suppliers);
        }),
      );
  }

  getSupplier(uuid: string): Observable<Supplier> {
    return this.suppliers$.pipe(
      filter((suppliers: Array<Supplier>) => suppliers !== null),
      map((suppliers: Array<Supplier>) => {
        return suppliers[suppliers.findIndex((supplier: Supplier) => supplier.uuid === uuid)];
      }),
    );
  }

  addSupplier(data: Supplier): Observable<Supplier> {
    return this.http.post<Supplier>('/api/administration/suppliers/', data).pipe(
      tap((supplierAdded: Supplier) => {
        const value = this.suppliers$.value;
        this.suppliers$.next([...value, supplierAdded]);
      }),
    );
  }

  editSupplier(uuid: string, data: Supplier): Observable<Supplier> {
    return this.http.put<Supplier>(`/api/administration/suppliers/${uuid}`, data).pipe(
      tap((supplierUpdated: Supplier) => {
        const value = this.suppliers$.value;
        this.suppliers$.next(value.map((supplier: Supplier) => {
          if (supplier.uuid === supplierUpdated.uuid) {
            return supplierUpdated;
          } else {
            return supplier;
          }
        }));
      }),
    );
  }

  deleteSupplier(uuid: string): void {
      this.http.delete(`/api/administration/suppliers/${uuid}`)
        .subscribe(() => {
          const suppliers = this.suppliers$.value;
          this.suppliers$.next(suppliers.filter((supplier: Supplier) => supplier.uuid !== uuid));
        });
  }
}
