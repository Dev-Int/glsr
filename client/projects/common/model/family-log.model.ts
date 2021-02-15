export interface FamilyLog {
  uuid?: string;
  label: string;
  parent?: string;
  path?: string;
  children?: Array<string>;
}
