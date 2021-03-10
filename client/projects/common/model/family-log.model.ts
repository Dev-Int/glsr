export interface FamilyLog {
  uuid?: string;
  label: string;
  parent?: string;
  level?: number;
  path?: string;
  children?: Array<string>;
}
