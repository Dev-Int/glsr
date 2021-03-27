import { FamilyLog } from './family-log.model';

export interface Supplier {
  uuid?: string;
  name: string;
  address: string;
  zipCode: string;
  town: string;
  country: string;
  fullAddress?: string;
  phone: string;
  facsimile: string;
  email: string;
  contactName: string;
  cellPhone: string;
  familyLog?: FamilyLog;
  familyLogId?: string;
  delayDelivery: number;
  orderDays: Array<number>;
  slug?: string;
  active?: boolean;
}
