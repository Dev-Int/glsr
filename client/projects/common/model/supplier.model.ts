export interface Supplier {
  uuid: string;
  name: string;
  address: string;
  zipCode: string;
  town: string;
  country: string;
  phone: string;
  facsimile: string;
  email: string;
  contact: string;
  cellphone: string;
  familyLog: string;
  delayDelivery: number;
  orderDays: Array<number>;
  active: boolean;
}
