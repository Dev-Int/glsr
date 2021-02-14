export interface FamilyLog {
  uuid?: string;
  name: string;
  parent?: string;
  path: string;
  children?: Array<string>;
}
