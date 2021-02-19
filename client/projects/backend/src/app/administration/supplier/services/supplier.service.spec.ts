import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';
import { TestBed } from '@angular/core/testing';

import { SupplierService } from './supplier.service';

describe('SupplierService', () => {
  let supplierService: SupplierService;
  let http: HttpTestingController;

  beforeEach(() =>
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule],
    }),
  );

  beforeEach(() => {
    supplierService = TestBed.inject(SupplierService);
    http = TestBed.inject(HttpTestingController);
  });

  it('should be created', () => {
    expect(supplierService).toBeTruthy();
  });

  it('should return an Observable of 2 suppliers', () => {
    const hardcodedSuppliers = [
      {
        uuid: 'a136c6fe-8f6e-45ed-91bc-586374791033',
        name: 'Davigel',
        address: '1 rue des freezes',
        zipCode: '75000',
        town: 'PARIS',
        country: 'France',
        phone: '0100000001',
        facsimile: '0100000001',
        email: 'contact@davigel.fr',
        contact: 'Laurent',
        cellphone: '0600000001',
        familyLog: 'surgele',
        delayDelivery: 1,
        orderDays: [1, 5],
        slug: 'davigel',
        active: 1,
      },
      {
        uuid: '004c2842-4aab-4337-b359-e57cb9a72bb2',
        name: 'Davifrais',
        address: '1 rue des fraises',
        zipCode: '75000',
        town: 'PARIS',
        country: 'France',
        phone: '0100000001',
        facsimile: '0100000001',
        email: 'contact@davifrais.fr',
        contact: 'Serge',
        cellphone: '0600000001',
        familyLog: 'surgele',
        delayDelivery: 1,
        orderDays: [1, 5],
        slug: 'davifrais',
        active: 1,
      },
    ];

    let actualSupplier = [];
    supplierService.getSuppliers().subscribe(suppliers => (actualSupplier = suppliers));

    http.expectOne('/api/administration/suppliers/')
      .flush(hardcodedSuppliers);

    expect(actualSupplier.length).toBe(2);
  });
});
