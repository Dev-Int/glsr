import { AbstractControl, ValidationErrors, ValidatorFn } from '@angular/forms';

export const CheckPasswordValidator: ValidatorFn = (control: AbstractControl): ValidationErrors | null => {
  const password = control.get('password');
  const confirm = control.get('password_confirm');

  return password && confirm && password.value !== confirm.value ? { notEqual: true } : null;
};
